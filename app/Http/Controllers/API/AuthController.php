<?php

namespace App\Http\Controllers\API;

use App\Models\Bet;
use App\Models\User;
use App\Models\Agent;
use App\Models\CashIn;
use App\Models\BetSlip;
use App\Models\CashOut;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\BlockNumber;
use App\Models\DefineAmount;
use Illuminate\Http\Request;
use App\Models\BannerSupport;
use App\Models\AgentCommission;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\General\GetDataController;

class AuthController extends Controller
{
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    public function create_user(Request $request){
        $validator  = Validator::make($request->all(), [
            'name' => 'required',
            'msisdn' => 'required|unique:users|numeric',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
        if($request->has('referal_code')){
            $check = Agent::where('referal_code', $request->referal_code)->first();
            if(!empty($check)){
                $user = new User();
                $user->name = $request->name;
                $user->msisdn = $request->msisdn;
                $user->password = Hash::make($request->password);
                $user->referal_code = $request->referal_code;
                $user->role = 'user';
                $user->save();
                $success['token'] =  $user->createToken('user')->plainTextToken;
                $success['name'] =  $user->name;
                

                return response()->json([
                    "message" => "success",
                    "data" => $user,
                    "token" => $success
                ],200);
            } else {
                return response()->json([
                    "message" => "Invalid Referal Code",
                ],400);
            }
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->msisdn = $request->msisdn;
            $user->password = Hash::make($request->password);
            $user->role = 'user';
            $user->save();

            $success['token'] =  $user->createToken('user')->plainTextToken;
            $success['name'] =  $user->name;

            return response()->json([
                "message" => "success",
                "data" => $user,
                "token" => $success
            ],200);
        }
    }

    public function log_in(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'msisdn' => 'required',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response()->json(["validation_errors"=>$validator->errors()]);
        }
    
        if(Auth::attempt(['msisdn' => $request->msisdn, 'password' => $request->password])){ 
            $authUser = User::where('id', Auth::user()->id)->first(); 
            $success['token'] =  $authUser->createToken('user')->plainTextToken; 
            $success['name'] =  $authUser->name;
   
            return $this->sendResponse($success, 'User signed in');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function cash_in(Request $request,$id){
        $validator  = Validator::make($request->all(), [
            'payment_id' => 'required',
            'amount' => 'required',
            'credential' => 'required',
            'transaction_id' => 'required',
            'name' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }

        return $this->storein($id, $request->name, $request->payment_id, $request->amount, $request->credential, $request->type,$request->transaction_id,'in');
    }

    public function cash_out(Request $request,$id){
        $validator  = Validator::make($request->all(), [
            'payment_id' => 'required',
            'amount' => 'required',
            'name' => 'required',
            'credential' => 'required',
            'type' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
        return $this->storein($id, $request->name, $request->payment_id, $request->amount, $request->credential, $request->type,'', 'out');
    }

    public function cash_in_payments(){
        $bank = 'banking';
        $bill = 'billing';
        $pay = 'mobile-pay';
        $setting = Setting::first();
        return response()->json([
            "message" => "success",
            "data" => [
               "banking" => Payment::orderBy('created_at', 'DESC')->where('type', $bank)->where('cashin_status',1)->get(),
               "phone_billing" => Payment::orderBy('created_at', 'DESC')->where('type', $bill)->where('cashin_status',1)->get(),
               "mobile_pay" => Payment::orderBy('created_at', 'DESC')->where('type', $pay)->where('cashin_status',1)->get(),
            ],
        ]);
    }

    public function cash_out_payments(){
        return response()->json([
            "message" => "success",
            "data" => [
               "banking" => Payment::orderBy('created_at', 'DESC')->where('type', 'banking')->where('cashout_status',1)->get(),
               "mobile_pay" => Payment::orderBy('created_at', 'DESC')->where('type', 'mobile-pay')->where('cashout_status',1)->get(),
            ],
        ]);
    }

    public function storein($id,$name, $payment_id, $amount, $credential, $type,$transaction, $req){
        $user = User::where('id', $id)->first();
        $payfind = Payment::where('id', $payment_id)->first();
        if(!empty($user)){
            if($req == 'in'){
                if($payfind->cashin_status == 1){
                    $cashin = new CashIn();
                    $cashin->name = $name;
                    $cashin->user_id = $user->id;
                    $cashin->payment_id = $payment_id;
                    if($type == 'billing'){
                        $cut = ($payfind->percent/100) * $amount;
                        $real_amount = $amount - $cut;
                    } else {
                        $real_amount = $amount;
                    }
                    $cashin->amount = $real_amount;
                    $cashin->old_amount = $user->amount;
                    $cashin->new_amount = (int) $user->amount + (int) $real_amount;
                    $cashin->credential = $credential;
                    $cashin->date = date('Y-m-d', time());
                    $cashin->transaction_id = $transaction;
                    $cashin->save();

                    $owner = User::where('role', 'owner')->first();
                    $cashin_noti = new GetDataController();
                    $cashin_noti->firebase_notification($owner->id, "Cash In", "User CashIn Request", "cashin");
                    return response()->json([
                        "message" => 'success'
                    ],200);
                } else {
                    return response()->json([
                        "message" => 'payment method is compatible with cash in.'
                    ],200);
                }
            } else {
                if($payfind->cashout_status == 1){
                    if((int) $user->amount >= (int) $amount){
                        $user->amount -= $amount;
                        $user->save();

                        $cashout = new CashOut();
                        $cashout->name = $name;
                        $cashout->user_id = $user->id;
                        $cashout->payment_id = $payment_id;
                        $cashout->amount = $amount;
                        $cashout->old_amount = $user->amount;
                        $cashout->new_amount = (int) $user->amount - (int) $amount;
                        $cashout->credential = $credential;
                        $cashout->date = date('Y-m-d', time());
                        $cashout->save();


                        $owner = User::where('role', 'owner')->first();
                        $cashout_noti = new GetDataController();
                        $cashout_noti->firebase_notification($owner->id, "Cash Out", "User CashOut Request", "cashout");
                        return response()->json([
                            "message" => 'success'
                        ],200);
                    } else {
                        return response()->json([
                            "message" => 'not enough amount.'
                        ],400);
                    }
                } else {
                    return response()->json([
                        "message" => 'payment method is compatible with cash out.'
                    ],200);
                }
            }
        } else {
            return response()->json([
                "message" => 'user not found.'
            ],400);
        }
    }
    
    public function closetime(){
        $data = [];
        $sections = DB::table('sections')->select('id', 'section', 'close_start_time', 'close_end_time','date')->get();
        foreach($sections as $section){
            array_push($data, [
                "id" => $section->id,
                "section" => date('h:i A', strtotime($section->section)),
                "close_start_time" => date('h:i A', strtotime($section->close_start_time)),
                "close_end_time" => date('h:i A', strtotime($section->close_end_time)),
                "date" => date('Y-m-d'),
            ]);
        }
        return response()->json([
            "message" => "success",
            "data" => $data
        ],200);
    }

    public function bet(Request $request){
        $id = Auth::user()->id;
        $data = json_decode($request->data,true);
        $date = date('Y-m-d', strtotime($request->date));

        $total_numbers = 0;
        $total_amounts = 0;
        $section = $request->section;
        foreach($data as $datum){
            $total_numbers += 1;
            $total_amounts += $datum['amount'];
        }

        if(Auth::user()->amount >= $total_amounts){
            $bet = new Bet();
            $bet->total_numbers = $total_numbers;
            $bet->total_amounts = $total_amounts;
            $bet->user_id = $id;
            $bet->date = $date;
            $bet->section = $section;
            $bet->save();
    
            foreach($data as $da){
                $betslip = new BetSlip();
                $betslip->user_id = $id;
                $betslip->bet_id = $bet->id;
                $betslip->date = $bet->date;
                $betslip->section = $bet->section;
                $betslip->number = $da['number'];
                $betslip->amount = $da['amount'];
                $betslip->save();
            }

            $user = User::where('id', $id)->first();
            $user->amount -= $total_amounts;
            $user->save();
    
            $referal_code = Auth::user()->referal_code;

            if($referal_code != null || $referal_code != ""){
                $find_referal = Agent::where('referal_code', $referal_code)->first();
                if(!empty($find_referal)){
                    $percent_amount = ($find_referal->percentage / 100) * $total_amounts;
                    $find_referal->amount += $percent_amount;
                    $find_referal->save();
    
                    $check_com = AgentCommission::where('date', $date)->where('section', $section)->where('agent_id', $find_referal->id)->first();
                    if(!empty($check_com)){
                        $check_com->earn_amount += $percent_amount;
                        $check_com->save();
                    } else {
                        $new_com = new AgentCommission();
                        $new_com->agent_id = $find_referal->id;
                        $new_com->section = $section;
                        $new_com->date = $date;
                        $new_com->earn_amount = $percent_amount;
                        $new_com->save();
                    }
                }
            }
    
            return response()->json([
                "message" => "success",
            ],200);
        } else {
            return response()->json([
                "message" => "not enough amount.",
            ],400);
        }
    }

    public function bethistory(Request $request){
        $data = [];
        $id = Auth::user()->id;
        $from = $request->query('from');
        $to = $request->query('to');
        $bets = Bet::where('user_id', $id)->whereBetween('date', [$from,$to])->orderBy('created_at', 'ASC')->get();
        foreach($bets as $bet){
            $slips = BetSlip::where('bet_id', $bet->id)->orderBy('created_at', 'ASC')->get();
            array_push($data,[
                "bet" => $bet,
                "detail" => $slips
            ]);
        }

        return response()->json([
            "message" => "success",
            "data" => $data
        ],200);
    }

    public function cash_history(Request $request){
        $req = $request->query('request');
        $data = [];
        $from = date('Y-m-d', strtotime($request->query('from')));
        $to = date('Y-m-d', strtotime($request->query('to')));
        if($req == 'in'){
            $cash = CashIn::whereBetween('date', [$from,$to])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        } else if($req == 'out') {
            $cash = CashOut::whereBetween('date', [$from,$to])->where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        }

        foreach($cash as $datum){
            $payment = Payment::where('id', $datum->payment_id)->first();
            array_push($data, [
                "payment" => $payment->name,
                "amount" => $datum->amount,
                "old_amount" => $datum->old_amount,
                "new_amount" => $datum->new_amount,
                "status" => $datum->approve,
                "date" => $datum->date
            ]);
        }

        return response()->json([
            "message" => "success",
            "data" => $data
        ],200);
    }

    public function define_amounts(Request $request){
        $date = $request->query('date');
        $section = $request->query('section');
        $data = [];
        $hots = DefineAmount::where('date', $date)->where('section', $section)->where('hot_amount', '!=', 0)->select('number','hot_amount')->get();
        $overall = Setting::select('overall_amount')->first();
        $odd = Setting::select('odd')->first();
        $blocks = BlockNumber::where('date', $date)->where('section', $section)->select('number')->get();
        $minmax = Setting::first();

        $current_amounts = BetSlip::where('date', $date)->where('section', $section)
        ->selectRaw("number as number")
        ->selectRaw("SUM(amount) as current_amount")
        ->groupBy('number')
        ->get();

        $numbers = $this->numbers();
        foreach($numbers as $num){
            $find = $current_amounts->where('number', $num)->first();
            if(!empty($find)){
                array_push($data,[
                    "number" => $find->number,
                    "current" => $find->current_amount 
                ]);
            } else {
                array_push($data,[
                    "number" => $num,
                    "current" => 0
                ]);
            }
        }
       
        return response()->json([
            "message" => "success",
            "data" => [
                "hotamounts" => $hots,
                "current_amount" => $data,
                "overall_amounts" => $overall,
                "blocknumbers" => $blocks,
                "min" => $minmax->min_amount,
                "max" => $minmax->max_amount,
                "odd" => $odd
            ]
        ],200);
    }

    public function numbers(){
        return [
            '00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15',
            '16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31',
            '32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47',
            '48','49','50','51','52','53','54','55','56','57','58','59','60','61','62','63',
            '64','65','66','67','68','69','70','71','72','73','74','75','76','77','78','79',
            '80','81','82','83','84','85','86','87','88','89','90','91','92','93','94','95',
            '96','97','98','99'
        ];
    }

    public function device_token(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $user->device_token = $request->token;
        $user->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function profile(Request $request){
        $user = User::where('id', Auth::user()->id)->first();
        if($user->img == null || $user->img == ""){
            $profile = [
                "id" => $user->id,
                "name" => $user->name,
                "amount" => $user->amount,
                "msisdn" => $user->msisdn,
                "img" => "https://ui-avatars.com/api/?name=" . $user->name ."&background=000&color=fff&size=256"
            ];
        } else {
            $profile = [
                "id" => $user->id,
                "name" => $user->name,
                "amount" => $user->amount,
                "msisdn" => $user->msisdn,
                "img" => "storage/users/" . $user->img
            ];
        }

        return response()->json([
            "message" => $profile
        ],200);
    }

    public function profile_update(Request $request){
        $user = User::where('id', Auth::user()->id)->first();
        if($request->has('new_password')){
            if($request->has('old_password')){
                $old = $request->old_password;
            } else {
                $old = '';
            }
            if(Hash::check($old, $user->password) == true){
                $user->password = Hash::make($request->new_password);
            } else {
                return response()->json([
                    "message" => 'old password is invalid.' 
                ],400);
            }
        }

        if($request->has('referal_code')){
            $agent = Agent::where('referal_code', $request->referal_code)->first();
            if(!empty($agent)){
                $user->referal_code = $request->referal_code;
            } else {
                return response()->json([
                    "message" => 'Referal code does not match.' 
                ],400);
            }
        } 

        if($request->has('name')){
            $user->name = $request->name;
        }

        if($request->hasFile('img')){
            $img = $request->img;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('users/' . $fileName, File::get($img));
            $user->img = $fileName;
        }

        $user->save();


        return response()->json([
            "message" => "success",
            "data" => $user
        ],200);
    }

    public function check_password(Request $request){
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        if(Hash::check($request->password, $user->password) == true){
            return response()->json([
                "message" => 'success' 
            ],200);
        } else {
            return response()->json([
                "message" => 'password is invalid.' 
            ],400);
        }
    }

    public function version_update(Request $request){
        $setting = Setting::first();
        if($request->query('req') != 'crypto'){
            if($setting->force_update == 1){
                $force = true;
            } else {
                $force = false;
            }
    
            $data = [
                "version_code" => $setting->version_code,
                "version_name" => $setting->version_name,
                "force_update" => $force
            ];
        } else {
            if($setting->force_update_crypto == 1){
                $force_crypto = true;
            } else {
                $force_crypto = false;
            }
    
            $data = [
                "version_code" => $setting->version_code_crypto,
                "version_name" => $setting->version_name_crypto,
                "force_update" => $force_crypto
            ];
        }

        

        return response()->json([
            "message" => "success",
            "data" => $data
        ]);
    }

    public function bannersupport(){
        $banners = BannerSupport::where('type', 'banner')->select('img')->get();
        $supports = BannerSupport::where('type', 'support')->select('img','name', 'body')->get();
        $marques = BannerSupport::where('type', 'marque')->select('body')->get();
        $setting = Setting::first();
        return response()->json([
            "message" => "success",
            "banners" => $banners,
            "supports" => $supports,
            "marquees" => $marques,
            "banner_path" => 'https://api.lucky8.website/storage/banners/',
            "support_path" => 'https://api.lucky8.website/storage/supports/',
            "cashin_link" => $setting->in_link,
            "cashout_link" => $setting->out_link,
        ],200);
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "success"
        ],200);
    }

    public function winners(Request $request){
        $section = $request->query('section');
        $data = [];
        $date = date('Y-m-d');
        $winners = BetSlip::where('date', $date)->where('status', 1)->orderBy('created_at', 'DESC')->get();
        foreach($winners as $winner){
            $bet = Bet::where('id', $winner->bet_id)->first();
            $user = User::where('id', $winner->user_id)->first();
            array_push($data, [
                "name" => $user->name,
                "winner_number" => $winner->number,
                "amount" => $winner->amount,
                "reward_amount" => $bet->reward,
                "created_at" => date('Y-m-d h:i A', strtotime($bet->created_at))
            ]);
        }
        
        return response()->json([
            "message" => "success",
            "data" => $data
        ]);
    }
}
