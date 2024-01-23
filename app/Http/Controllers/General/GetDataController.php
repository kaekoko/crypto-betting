<?php

namespace App\Http\Controllers\General;

use App\Models\Bet;
use App\Models\User;
use App\Models\BetSlip;
use App\Models\Setting;
use App\Models\Clearance;
use App\Models\BlockNumber;
use App\Models\LuckyNumber;
use App\Models\AgentCashOut;
use App\Models\DefineAmount;
use Illuminate\Http\Request;
use App\Models\AgentCommission;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class GetDataController extends Controller
{
    public function get_numbers(Request $request){
        $data = [];
        $date = date('Y-m-d', strtotime($request->query('date')));
        $section = $request->query('section');
        for ($x = 0; $x <= 99; $x++) {
            $p = strval($x);
            if(strlen($p) == 1){
                $v = '0' . $p;
            } else {
                $v = $p;
            }
            $betslip = BetSlip::where('number', $v)->where('section', $section)->where('date', $date)->get();
            $block = BlockNumber::where('number', $v)->where('date', $date)->where('section', $section)->first();
            $define = DefineAmount::where('number', $v)->where('date', $date)->where('section', $section)->first();
            if(!empty($define)){
                $hot = $define->hot_amount;
            } else {
                $hot = 0;
            }

            if(!empty($block)){
                $b = 1;
            } else {
                $b = 0;
            }

            if($betslip->count() > 0){
                $push = [
                    "number" => $v,
                    "total_amount" => $betslip->sum('amount'),
                    "hot" => $hot ,
                    "block" => $b 
                ];
            } else {
                $push = [
                    "number" => $v,
                    "total_amount" => 0,
                    "hot" => $hot,
                    "block" => $b 
                ];
            }
            array_push($data, $push);
        }

        $hot = DefineAmount::where('date', $date)->where('section', $section)->get();

        return response()->json($data);
    }

    public function get_define_amount(Request $request){
        $number = $request->query('number');
        $res = [];
        $date = date('Y-m-d', strtotime($request->query('date')));
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $define = DefineAmount::where('date', $date)->where('section', $section)->where('number', $number)->first();
        $users = BetSlip::where('date', $date)->where('section', $section)->where('number', $number)
        ->selectRaw('SUM(amount) as amounts')
        ->selectRaw('user_id as id')
        ->groupBy('user_id')->get();
        foreach($users as $user){
            $u = User::where('id', $user->id)->first();
            array_push($res,[
                "amounts" => $user->amounts,
                "name" => $u->name
            ]); 
        }

        if(!empty($define)){
            $data = [
                "hot_amount" => $define->hot_amount,
            ];
        } else {
            $data = [
                "hot_amount" => 0,
            ];
        }

        return response()->json([
            "data" => $data,
            "users" => $res
        ]);
    }

    public function slips(Request $request){
        $data = [];
        $date = $request->query('date');
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $bets = Bet::where('date', $date)->where('section', $section)->orderBy('created_at', 'DESC')->get();
        foreach($bets as $bet){
            $user = User::where('id', $bet->user_id)->first();
            array_push($data,[
                "id" => $bet->id,
                "name" => $user->name,
                "total_amounts" => $bet->total_amounts,
                "total_numbers" => $bet->total_numbers,
                "created_at" => date('Y-m-d', strtotime($bet->created_at)),
                "section" => $bet->section,
                "status" => $bet->status,
                "active" => $bet->active
            ]);
        }
        return DataTables::of($data) 
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" class="check-detail btn btn-success detail-btn"  data-bs-toggle="tooltip" data-bs-placement="top" title="detail"><i class="fa-solid fa-eye"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function getslipdetail(Request $request){
        $data = [];
        $id = $request->query('id');
        $bets = BetSlip::orderBy('created_at', 'DESC')->where('bet_id', $id)->get();
        foreach($bets as $bet){
            $user = User::where('id', $bet->user_id)->first();
            array_push($data,[
                "id" => $bet->id,
                "name" => $user->name,
                "number" => $bet->number,
                "amount" => $bet->amount,
                "created_at" => date('Y-m-d', strtotime($bet->created_at)),
                "section" => $bet->section,
                "status" => $bet->status,
                "active" => $bet->active
            ]);
        }
        return DataTables::of($data) 
        ->make(true);
    }

    public function statics(Request $request){
        $date = $request->query('date');
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $agentcom = AgentCommission::where('date', $date)->where('section', $section)->sum('earn_amount');
        $check = Clearance::where('date', $date)->where('section', $section)->first();
        $query = Bet::where('date', $date)->where('section', $section)->get();
        $total_amount = $query->sum('total_amounts');
        $gp = Bet::where('date', $date)->where('section', $section)->pluck('user_id')->toArray();
        $uni = array_values(array_unique($gp));
        $total_users = count($uni);
        if(!empty($check)){
            $total_reward = $query->sum('reward');
            $first = $total_reward + $agentcom;
            $profit = $total_amount - $first;
        } else {
            $total_reward = 'Coming Soon.';
            $profit = 'Coming Soon.';
        }

        $luckynumber = LuckyNumber::where('date', $date)->where('section', $section)->first();

        if(!empty($luckynumber)){
            $lucky = $luckynumber->number;
        } else {
            $lucky = '--';
        }

        return response()->json([
            "agentcom" => $agentcom,
            "total_amounts" => $total_amount,
            "total_reward" => $total_reward,
            "total_users" => $total_users,
            "profit" => $profit,
            "luckynumber" => $lucky
        ]);
    }

    public function clearance(Request $request){
        $date = $request->query('date');
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $find_clear = Clearance::where('section', $section)->where('date', $date)->first();
        if(empty($find_clear)){
            $id = Auth::user()->id;
            $user = User::where('id', $id)->where('role', 'owner')->first();
            if(Hash::check($request->password, $user->password) == true){
                $find_lucky = LuckyNumber::where('date', $date)->where('section', $section)->first();
                if(!empty($find_lucky)){
                    $bets = Bet::where('date', $date)->where('section', $section)->get();
                    foreach($bets as $bet){
                        $user_id = $bet->user_id;
                        $user = User::where('id', $user_id)->first();
                        if($bet->status == 1){
                            $user->amount += $bet->reward;
                            $user->save();
                        }
                    }

                    $clearance = new Clearance();
                    $clearance->section = $section;
                    $clearance->date = $date;
                    $clearance->save();

                    $message = "success";

                } else {
                    $message = "Luck Number still pending.You can't clearance.";
                } 
            } else {
                $message = "Password does not match.";
            }
        } else {
            $message = "You already cleared the section.";
        }
       
        return response()->json([
            "message" => $message
        ]);
    }

    public function refunds(Request $request){
        $date = $request->query('date');
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $bets = Bet::where('date', $date)->where('section', $section)->get();
        $id = Auth::user()->id;
        $user = User::where('id', $id)->where('role', 'owner')->first();
        if(Hash::check($request->password, $user->password) == true){
            foreach($bets as $bet){
                $bet->active = 'reject';
                $bet->save();
                
                $user_id = $bet->id;
                $user = User::where('id', $bet->user_id)->first();
                $user->amount += $bet->total_amounts;
                $user->save();

                $com = AgentCommission::where('date', $date)->where('section', $section)->get();
                foreach($com as $c){
                    $c->earn_amount = 0;
                    $c->save();
                }

                $betslips = BetSlip::where('bet_id', $bet->id)->first();
                $betslips->active = 'reject';
                $betslips->save();
            }
            $message = "success";
        } else {
            $message = "Password does not match.";
        }

        return response()->json([
            "message" => $message
        ]);
    }

    public function get_histories(Request $request){
        $from = date('Y-m-d', strtotime($request->query('from')));
        $to = date('Y-m-d', strtotime($request->query('to')));
        $data = [];
        if($request->query('section') == 'all'){
            $betting = Bet::whereBetween('date', [$from, $to])->orderBy('created_at', 'DESC')->get();
        } else {
            $section = date('h:i A', strtotime($request->query('section')));
            $betting = Bet::whereBetween('date', [$from, $to])->where('section', $section)->orderBy('created_at', 'DESC')->get();
        }
        foreach($betting as $bet){
            $user = User::where('id', $bet->user_id)->first();
            $lucky_number = LuckyNumber::where('date', $bet->date)->where('section', $bet->section)->first();
            if(!empty($lucky_number)){
                $l = $lucky_number->number;
            } else {
                $l = '-';
            }
            array_push($data, [
                "id" => $bet->id,
                "name" => $user->name,
                "total_amounts" => $bet->total_amounts,
                "total_numbers" => $bet->total_numbers,
                "lucky_number" => $l,
                "section" => $bet->section,
                "status" => $bet->status,
                "active" => $bet->active,
                "created_at" => date('Y-m-d', strtotime($bet->created_at)),
            ]);
        }
        return DataTables::of($data)
        ->addColumn('action', function($row){
            $actionBtn = '<button id="'. $row['id'] .'" data-lucky="'. $row['lucky_number'] .'" class="view-detail btn btn-success user-btn-danger ml"  data-bs-toggle="tooltip" data-bs-placement="top" title="detail"><i class="fa-solid fa-eye"></i></button>';
            return $actionBtn;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function get_detail_hisotries(Request $request){
        $data = [];
        $id = $request->query('id');
        $betting = BetSlip::where('bet_id', $id)->orderBy('created_at', 'DESC')->get();
        foreach($betting as $bet){
            $user = User::where('id', $bet->user_id)->first();
            array_push($data, [
                "id" => $bet->id,
                "name" => $user->name,
                "number" => $bet->number,
                "amount" => $bet->amount,
                "section" => $bet->section,
                "status" => $bet->status,
                "active" => $bet->active,
                "created_at" => date('Y-m-d', strtotime($bet->created_at)),
            ]);
        }
        return DataTables::of($data)
        ->make(true);
    }

    public function get_cashout_detail(Request $request, $id){
        $agent = AgentCashOut::where('agent_id', $id)->orderBy('created_at', 'DESC')->get();
        return DataTables::of($agent)
        ->make(true);
    }

    public function get_arrange_statics(Request $request){
        $from = date('Y-m-d', strtotime($request->query('from')));
        $to = date('Y-m-d', strtotime($request->query('to')));
        if($request->query('section') == 'all'){
            $agentcom = AgentCommission::whereBetween('date', [$from,$to])->sum('earn_amount');
            $check = Clearance::whereBetween('date', [$from,$to])->first();
            $query = Bet::whereBetween('date', [$from,$to])->get();
            $total_amount = $query->sum('total_amounts');
            $gp = Bet::whereBetween('date', [$from,$to])->pluck('user_id')->toArray();
        } else {
            $section = date('h:i A', strtotime($request->query('section')));
            $agentcom = AgentCommission::whereBetween('date', [$from,$to])->where('section', $section)->sum('earn_amount');
            $check = Clearance::whereBetween('date', [$from,$to])->where('section', $section)->first();
            $query = Bet::whereBetween('date', [$from,$to])->where('section', $section)->get();
            $total_amount = $query->sum('total_amounts');
            $gp = Bet::whereBetween('date', [$from,$to])->where('section', $section)->pluck('user_id')->toArray();
        }
        

        $uni = array_values(array_unique($gp));
        $total_users = count($uni);
        
        if(!empty($check)){
            $total_reward = $query->sum('reward');
            $first = $total_reward + $agentcom;
            $profit = $total_amount - $first;
        } else {
            $total_reward = 'Coming Soon.';
            $profit = 'Coming Soon.';
        }

        return response()->json([
            "agentcom" => $agentcom,
            "total_amounts" => $total_amount,
            "total_reward" => $total_reward,
            "total_users" => $total_users,
            "profit" => $profit
        ]);
    }

    public function storeadmintoken(Request $request){
        $token = $request->token;
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();
        $user->device_token = $token;
        $user->save();
        
        return response()->json(['Token successfully stored.']);
    }

    public function firebase_notification($id,$topic, $body,$type){
       
        $FcmToken = User::where('id', $id)->whereNotNull('device_token')->pluck('device_token')->all();
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = 'AAAAy2QHOx8:APA91bGoPmUhMipaCfV-6w-1zMo13t1lGQgTUscQH87xDrsctrv9lUPaY_-avFzgGG3nefxJ2Qa65cl6YMPWvFeW2sK0KiS-fcvoZLWpIlHEoXSft3VW7118DY53afi51NTAhp5jobZS';

        $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $topic,
                "body" => $body,
                "type" => $type
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } 
        curl_close($ch);
    }

    public function noti_test(){
        return $this->firebase_notification('1', 'cash', 'cahsin', 'in');
    }

    public function getwinners(Request $request){
        $section = $request->query('section');
        $data = [];
        $date = date('Y-m-d');
        $winners = BetSlip::where('section', $section)->where('date', $date)->where('status', 1)->get();
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
        return DataTables::of($data) 
        ->make(true);
    }
  public function luckynumber(){

        $date = date('Y-m-d');
        $luckynumber = LuckyNumber::where('date', $date)->get();
        
        return $luckynumber;
    }
    
}
