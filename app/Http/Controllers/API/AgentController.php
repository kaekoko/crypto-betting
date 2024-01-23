<?php

namespace App\Http\Controllers\API;

use App\Models\Bet;
use App\Models\User;
use App\Models\Agent;
use App\Models\AgentCashOut;
use Illuminate\Http\Request;
use App\Models\AgentCommission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
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

    public function agent_login(Request $request){
        $request->validate([
            'msisdn' => 'required',
            'password' => 'required|min:6',
        ]);
    
        if(Auth::guard('agent')->attempt(['msisdn' => $request->msisdn, 'password' => $request->password])){ 
            $agent = Auth::guard('agent')->user();
            $success['token'] =  $agent->createToken('agent')->plainTextToken; 
            $success['name'] =  $agent->name;
   
            return $this->sendResponse($success, 'Agent signed in');
        } else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function agent_profile(Request $request){
        $agent = $request->user()->id;
        if(!empty($agent)){
            $find = Agent::where('id', $agent)->first();
            if($find->img == null || $find->img == ""){
                $img = "https://ui-avatars.com/api/?name=" . $find->name ."&background=000&color=fff&size=256";
            } else {
                $img = $find->img;
            }
            return response()->json([
                "message" => "success",
                "data" => [
                    "id" => $find->id,
                    "name" => $find->name,
                    "msisdn" => $find->msisdn,
                    "referal_code" => $find->referal_code,
                    "amount" => $find->amount,
                    "img" => $img
                ]
            ]);
        }

        return response()->json([
            "message" => "bad request.",
        ],400);
    }

    public function agent_profile_update(Request $request){
        $agent = $request->user()->id;
        $agent = Agent::where('id', $agent)->first();
        if($request->has('new_password')){
            if($request->has('old_password')){
                $old = $request->old_password;
            } else {
                $old = '';
            }
            if(Hash::check($old, $agent->password) == true){
                $agent->password = Hash::make($request->new_password);
            } else {
                return response()->json([
                    "message" => 'old password is invalid.' 
                ],400);
            }
        }


        if($request->has('name')){
            $agent->name = $request->name;
        }

        if($request->hasFile('img')){
            $img = $request->img;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('agents/' . $fileName, File::get($img));
            $agent->img = $fileName;
        }

        $agent->save();


        return response()->json([
            "message" => "success",
            "data" => $agent
        ],200);
    }

    public function agent_bet_slips(Request $request){
        $date = date('Y-m-d', strtotime($request->query('date')));
        $data = [];
        $agent = $request->user()->id;
        $find = Agent::where('id', $agent)->first();
        $users = User::where('referal_code', $find->referal_code)->get();
        $total_amount = 0;
        foreach($users as $user){
            $slips = Bet::where('user_id', $user->id)->where('date', $date)->orderBy('created_at', 'DESC')->get();
            foreach($slips as $slip){
                array_push($data, [
                    "id" => $slip->id,
                    "name" => $user->name,
                    "total_numbers" => $slip->total_numbers,
                    "total_amount" => $slip->total_amounts,
                    "reward" => $slip->reward,
                    "status" => $slip->status,
                    "commission" => ($find->percentage / 100) * $slip->total_amounts,
                    "section" => $slip->section,
                    "date" => $slip->date,
                    "active" => $slip->active
                ]);
                $total_amount += $slip->total_amounts;
            }
        }

        $total_commission = AgentCommission::where('agent_id' ,$find->id)->where('date', $date)->sum('earn_amount');

        return response()->json([
            "message" => "success",
            "data" => $data,
            "total_commission" => $total_commission,
            "total_amount" => $total_amount 
        ],200);
    }

    public function agent_cashout(Request $request){
        $agent = $request->user()->id;
        $date = date('Y-m-d', strtotime($request->query('date')));
        $agent_cash_out = AgentCashOut::where('agent_id', $agent)->whereDate('created_at', $date)->orderBy('created_at', 'DESC')->get();
        return response()->json([
            "message" => "success",
            "data" => $agent_cash_out
        ],200);
    }

    public function agent_users(Request $request){
        $agent = $request->user()->id;
        $find = Agent::where('id', $agent)->first();
        $users = User::where('referal_code', $find->referal_code)->get();

        return response()->json([
            "message" => "success",
            "data" => $users
        ]); 
    }

    public function agente_create_user(Request $request){
        $validator  = Validator::make($request->all(), [
            'name' => 'required',
            'msisdn' => 'required|unique:users|numeric',
            'password' => 'required|min:6',
        ]);
        if($validator->fails()){
            return $this->sendError('Error validation', $validator->errors());       
        }
        $agent = $request->user()->id;

        $check = Agent::where('id', $agent)->first();
        if(!empty($check)){
            $user = new User();
            $user->name = $request->name;
            $user->msisdn = $request->msisdn;
            $user->password = Hash::make($request->password);
            $user->referal_code = $check->referal_code;
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
                "message" => "Agent not found.",
            ],400);
        }
    }
}
