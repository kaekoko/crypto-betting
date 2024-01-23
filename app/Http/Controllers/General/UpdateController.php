<?php

namespace App\Http\Controllers\General;

use App\Models\User;
use App\Models\Agent;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Payment;
use App\Models\BlockNumber;
use App\Models\AgentCashOut;
use App\Models\DefineAmount;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BannerSupport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    public function ban_agent(Request $request,$id){
        $agent = Agent::findOrFail($id);
        if($request->query('suspend') == 1){
            $agent->is_suspend = 0;
        } else {
            $agent->is_suspend = 1;
        }
        $agent->save();
       
        return response()->json([
            "message" => "success",
            "data" => $agent
        ]);
    }

    public function delete_agent(Request $request,$id){
        $agent = Agent::findOrFail($id);
        $agent->delete();
       
        return response()->json([
            "message" => "success",
            "data" => $agent
        ]);
    }

    public function ban_user(Request $request,$id){
        $user = User::findOrFail($id);
        if($request->query('suspend') == 1){
            $user->is_suspend = 0;
        } else {
            $user->is_suspend = 1;
        }
        $user->save();
       
        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }

    public function delete_user(Request $request,$id){
        $user = User::findOrFail($id);
        $user->delete();

        $user_cashin = CashIn::where('user_id', $user->id)->get();
        foreach($user_cashin as $ci){
            $ci->delete();
        }

        $user_cashout = CashOut::where('user_id', $user->id)->get();
        foreach($user_cashout as $co){
            $co->delete();
        }

        return response()->json([
            "message" => "success",
            "data" => $user
        ]);
    }

    public function delete_block(Request $request,$id){
        $block = BlockNumber::findOrFail($id);
        $block->delete();
       
        return response()->json([
            "message" => "success",
            "data" => $block
        ]);
    }

    public function delete_payment(Request $request,$id){
        $pay = Payment::findOrFail($id);
        $pay->delete();

        $ins = CashIn::where('payment_id', $id)->get();
        foreach($ins as $in){
            $in->delete();
        }

        $outs = CashOut::where('payment_id', $id)->get();
        foreach($outs as $out){
            $out->delete();
        }
       
        return response()->json([
            "message" => "success",
            "data" => $pay
        ]);
    }

    public function  gettotal_cashin(){
        $cashin = CashIn::where('approve', 1)->sum('amount');
        return response()->json([
            "message" => "success",
            "data" => $cashin
        ]);
    }

    public function  gettotal_cashout(){
        $cashin = CashOut::where('approve', 1)->sum('amount');
        return response()->json([
            "message" => "success",
            "data" => $cashin
        ]);
    }

    public function  gettotal_users(){
        $users = User::where('role', 'user')->count();
        $total_amounts = User::where('role', 'user')->sum('amount');
        return response()->json([
            "message" => "success",
            "data" => $users,
            "amount" => $total_amounts
        ]);
    }

    public function  gettotal_agents(){
        $users = Agent::count();
        $total_amounts = Agent::sum('amount');
        return response()->json([
            "message" => "success",
            "data" => $users,
            "amount" => $total_amounts
        ]);
    }

    public function payment_in_status(Request $request,$id){
        $status = $request->query('status');

        $payment = Payment::where('id', $id)->first();
        $payment->cashin_status = $status;
        $payment->save();
    }

    public function payment_out_status(Request $request,$id){
        $status = $request->query('status');

        $payment = Payment::where('id', $id)->first();
        $payment->cashout_status = $status;
        $payment->save();
    }

    public function change_define_amount(Request $request){
        $number = $request->query('number');
        $date = date('Y-m-d', strtotime($request->query('date')));
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        $define = DefineAmount::where('date', $date)->where('section', $section)->where('number', $number)->first();
     
        if(!empty($define)){
            if($request->query('status') == 'hot'){
                $define->hot_amount = $request->query('amount');
            } else {
                $define->overall_amount = $request->query('amount');
            }
            $define->save();

            $res = [
                "status" => $request->query('status'),
                "data" => $request->amount
            ];
        } else {
            $new = new DefineAmount();
            $new->number = $number;
            $new->section = $section;
            $new->date = $date;
            if($request->query('status') == 'hot'){
                $new->hot_amount = $request->query('amount');
            } else {
                $new->overall_amount = $request->query('amount');
            }
            $new->save();

            $res = [
                "status" => $request->query('status'),
                "data" => $request->amount
            ];
        }
        
        return response()->json($res);
    }

    public function edit_agent(Request $request,$id){
        $request->validate([
            'username' => 'required|max:20|min:4',
            'msisdn' => 'required',
            'percentage' => 'required|numeric'
        ]);
        $agent = Agent::findOrFail($id);
        $agent->name = $request->username;
        $agent->msisdn = $request->msisdn;
        $agent->percentage = $request->percentage;
        $agent->save();


        return response()->json([
            "message" => "success",
            "data" => $agent 
        ]);
    }

    public function edit_customer(Request $request,$id){
        $request->validate([
            'username' => 'required|max:20|min:4',
            'msisdn' => 'required',
        ]);
        $customer = User::findOrFail($id);
        $customer->name = $request->username;
        $customer->msisdn = $request->msisdn;
        $customer->save();


        return response()->json([
            "message" => "success",
            "data" => $customer 
        ]);
    }

    public function edit_block(Request $request,$id){
        $request->validate([
            'number' => 'required|min:2|max:2',
        ]);
        $block = BlockNumber::findOrFail($id);
        $block->number = $request->number;
        $block->save();


        return response()->json([
            "message" => "success",
            "data" => $block 
        ]);
    }

    public function edit_payment(Request $request,$id){
        $request->validate([
            'name' => 'required',
            'holder' => 'required',
            'account_number' => 'required',
        ]);
        $payment = Payment::findOrFail($id);
        $payment->name = $request->name;
        $payment->holder = $request->holder;
        $payment->account_number = $request->account_number;
        if($request->type == 'billing'){
            $payment->percent = $request->percent;
        }

        if($request->hasFile('img')){
            $img = $request->img;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('payments/' . $fileName, File::get($img));
            $payment->logo = $fileName;
        }

        $payment->save();


        return response()->json([
            "message" => "success",
            "data" => $payment 
        ]);
    }

    public function blast_noti($id){
        $noti = Notification::where('id', $id)->first();
        // $not
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = 'AAAAy2QHOx8:APA91bGoPmUhMipaCfV-6w-1zMo13t1lGQgTUscQH87xDrsctrv9lUPaY_-avFzgGG3nefxJ2Qa65cl6YMPWvFeW2sK0KiS-fcvoZLWpIlHEoXSft3VW7118DY53afi51NTAhp5jobZS';

        $data = [
            "to" => "fFvGfeNfSMODeTyLXB5ZTu:APA91bH9UQ01MoJtUF9L7gWj-BkoRmKn2tCWcfUCH0YZ9gUluvdxRJnPLcZo2asXBuLxSGVo5dJ_oNsCBAr4zoib8bo89l6i7CPguB2In-cTi0PLxKi7aFMXsrxgvxKONuHCJE7nYFj2",
            "notification" => [
                "title" => $noti->title,
                "body" => $noti->body,
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
            $message = "failed.";
        } else {
            $message = "success";
            $noti->status = 1;
            $noti->save();
        }
        curl_close($ch);

        return response()->json([
            "message" => $message
        ]);
    }

    public function edit_banner(Request $request,$id){
        $new = BannerSupport::findOrFail($id);
        if($request->has('file')){
            $img = $request->file;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('banners/' . $fileName, File::get($img));
            $new->img = $fileName;
        }
        $new->save();
        return response()->json([
            "message" => "success"
        ]);
    }

    public function edit_support(Request $request,$id){
        $new = BannerSupport::findOrFail($id);
        if($request->has('file')){
            $img = $request->file;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('supports/' . $fileName, File::get($img));
            $new->img = $fileName;
        }
        $new->body = $request->body;
        $new->name = $request->name;
        $new->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function edit_marque(Request $request,$id){
        $new = BannerSupport::findOrFail($id);
        $new->body = $request->body;
        $new->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function delete_banner($id){
        $banner = BannerSupport::findOrFail($id);
        $banner->delete();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function delete_support($id){
        $support = BannerSupport::findOrFail($id);
        $support->delete();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function delete_marque($id){
        $marque = BannerSupport::findOrFail($id);
        $marque->delete();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function delete_hot(Request $request){
        $numbers = $request->numbers;
        $section = date('h:i A', strtotime($request->query('section')));
        if(strpos($numbers,',') !== false){
            $explode = explode(',', $numbers);
            foreach($explode as $ex){
                $define = DefineAmount::where('date', date('Y-m-d'))->where('section', $section)->where('number', $ex)->first();
                $define->delete();
            }   
        }
        return response()->json([
            "message" => "success"
        ]);
    }

    public function cashoutagent(Request $request, $id){
        $amount = $request->amount;
        $find = Agent::where('id', $id)->first();
        $old = $find->amount;
        if($find->amount >= $amount){
            $find->amount -= $amount;
            $find->save();

            $new = new AgentCashOut();
            $new->agent_id = $find->id;
            $new->amount = $amount;
            $new->old_amount = $old;
            $new->new_amount = $find->amount;
            $new->save();

            return response()->json([
                "message" => "success"
            ]);
        } else {
            return response()->json([
                "message" => "not enought amount."
            ]);
        }
    }

    public function cashoutcustomer(Request $request, $id){
        $amount = $request->amount;
        $find = User::where('id', $id)->first();
        $old = $find->amount;
        if($find->amount >= $amount){
            $find->amount -= $amount;
            $find->save();
            
            return response()->json([
                "message" => "success"
            ]);
        } else {
            return response()->json([
                "message" => "not enought amount."
            ]);
        }
    }

    public function cashincustomer(Request $request, $id){
        $amount = $request->amount;
        $find = User::where('id', $id)->first();
        $find->amount += $amount;
        $find->save();
            
        return response()->json([
            "message" => "success"
        ]);
    }
}
