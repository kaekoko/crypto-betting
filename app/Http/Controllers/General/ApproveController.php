<?php

namespace App\Http\Controllers\General;

use App\Models\User;
use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApproveController extends Controller
{
    public function cashin_approve($id){
        $cash = CashIn::findOrFail($id);
        $cash->approve = 1;
        $cash->save();

        $payment = Payment::where('id', $cash->payment_id)->first();
        
        $user = User::where('id', $cash->user_id)->first();
        $user->amount += $cash->amount;
        $user->save();

        if($user->device_token != "" || $user->device_token != null){
            $this->notification($user->device_token, 'in', 'approved');
        }

        return response()->json([
            "message" => "success"
        ]);
    }

    public function cashin_reject($id){
        $cash = CashIn::findOrFail($id);
        $cash->approve = 0;
        $cash->save();

        $user = User::where('id', $cash->user_id)->first();

        if($user->device_token != "" || $user->device_token != null){
            $this->notification($user->device_token, 'in', 'rejected');
        }

        return response()->json([
            "message" => "success"
        ]);
    }

    public function cashout_approve($id){
        $cash = CashOut::findOrFail($id);
        $cash->approve = 1;
        $cash->save();
        
        if($user->device_token != "" || $user->device_token != null){
            $this->notification($user->device_token, 'out', 'approved');
        }
        return response()->json([
            "message" => "success"
        ]);
    }

    public function cashout_reject($id){
        $cash = CashOut::findOrFail($id);
        $cash->approve = 0;
        $cash->save();

        $user = User::where('id', $cash->user_id)->first();

        if($user->device_token != "" || $user->device_token != null){
            $this->notification($user->device_token, 'out', 'rejected');
        }

        return response()->json([
            "message" => "success"
        ]);
    }

    public function notification($token, $type, $status){
        $url = 'https://fcm.googleapis.com/fcm/send';

        $serverKey = 'AAAAy2QHOx8:APA91bGoPmUhMipaCfV-6w-1zMo13t1lGQgTUscQH87xDrsctrv9lUPaY_-avFzgGG3nefxJ2Qa65cl6YMPWvFeW2sK0KiS-fcvoZLWpIlHEoXSft3VW7118DY53afi51NTAhp5jobZS';

        $data = [
            "to" => $token,
            "notification" => [
                "title" => "Your cash " . $type . " is now " . $status . ".",
                "body" => "Control from Lucky 8 Admin Team.",
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
        curl_close($ch);
    }
}
