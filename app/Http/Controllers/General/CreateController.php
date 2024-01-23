<?php

namespace App\Http\Controllers\General;

use App\Models\User;
use App\Models\Agent;
use App\Models\Payment;
use App\Models\Section;
use App\Models\Setting;
use App\Models\BlockNumber;
use App\Models\DefineAmount;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\BannerSupport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class CreateController extends Controller
{
    public function create_agent(Request $request){
        $request->validate([
            'username' => 'required|max:20|min:4',
            'msisdn' => 'required|unique:agents',
            'password' => 'required|min:6',
        ]);


        $new = new Agent();
        $new->name = $request->username;
        $new->msisdn = $request->msisdn;
        $new->password = Hash::make($request->password);
        $new->percentage = $request->percentage;
        $new->referal_code = substr(str_shuffle("0123456789abcdefghijklmnopqrstvwxyz"), 0, 7);
        $new->save();
        
        $agent = Agent::where('msisdn', $new->msisdn)->first();
        return response()->json([
            "message" => "success",
            "data" => $agent
        ]);
    }

    public function create_customer(Request $request){
        $request->validate([
            'firstname' => 'required|max:20|min:4',
            'lastname' => 'required|max:20|min:4',
            'msisdn' => 'required|unique:users',
            'password' => 'required|min:6',
        ]);

        if($request->referal_code !== null){
            $find = Agent::where('referal_code', $request->referal_code)->first();
            if(!empty($find)){
                $username = $request->firstname . ' ' . $request->lastname;
                $new = new User();
                $new->name = $username;
                $new->msisdn = $request->msisdn;
                $new->password = Hash::make($request->password);
                $new->referal_code = $request->referal_code;
                $new->role = 'user';
                $new->save();

                $user = User::where('msisdn', $new->msisdn)->first();

                return response()->json([
                    "message" => "success",
                    "data" => $user
                ],200);
            } else {
                return response()->json([
                    "message" => "Referal Code is invalid",
                ],200);
            }
        } else{
            $username = $request->firstname . ' ' . $request->lastname;
            $new = new User();
            $new->name = $username;
            $new->msisdn = $request->msisdn;
            $new->password = Hash::make($request->password);
            $new->role = 'user';
            $new->save();

            $user = User::where('msisdn', $new->msisdn)->first();

            return response()->json([
                "message" => "success",
                "data" => $user
            ],200);
        }
    }

    public function create_block(Request $request){
        $request->validate([
            'number' => 'required|max:2',
        ]);
        $date = date('Y-m-d', strtotime($request->date));
        $section = Section::where('id', $request->section)->first();
        $find = BlockNumber::where('number', $request->number)->where('date', $date)->where('section', date('h:i A', strtotime($section->section)))->first();
        if(empty($find)){
            $new = new BlockNumber();
            $new->number = $request->number;
            $new->section =  date('h:i A', strtotime($section->section));
            $new->date = $request->date;
            $new->save();
            
            return response()->json([
                "message" => "success",
                "data" => $new
            ]);
        } else {
            return response()->json([
                "message" => "Block number already exist.",
            ]);
        }
    }

    public function multiple_block(Request $request){
        $date = date('Y-m-d', strtotime($request->date));
        $section = Section::where('id', $request->section)->first();
        $numbers = $request->numbers;
        if(strpos($numbers, ',') !== false){
            $explode = explode(',', $numbers);
            foreach($explode as $ex){
                $find = BlockNumber::where('number', $ex)->where('date', $date)->where('section', date('h:i A', strtotime($section->section)))->first();
                if(empty($find)){
                    $new = new BlockNumber();
                    $new->number = $ex;
                    $new->section =  date('h:i A', strtotime($section->section));
                    $new->date = $request->date;
                    $new->save();
                } else {
                    $find->delete();
    
                    $new = new BlockNumber();
                    $new->number = $ex;
                    $new->section =  date('h:i A', strtotime($section->section));
                    $new->date = $request->date;
                    $new->save();
                }
            }
        } else {
            $find = BlockNumber::where('number', $numbers)->where('date', $date)->where('section', date('h:i A', strtotime($section->section)))->first();
            if(empty($find)){
                $new = new BlockNumber();
                $new->number = $numbers;
                $new->section =  date('h:i A', strtotime($section->section));
                $new->date = $request->date;
                $new->save();
            } else {
                $find->delete();

                $new = new BlockNumber();
                $new->number = $numbers;
                $new->section =  date('h:i A', strtotime($section->section));
                $new->date = $request->date;
                $new->save();
            }
        }
      
        return response()->json([
            "message" => "success",
        ]);
    }

    public function create_payment(Request $request){
        $request->validate([
            'name' => 'required',
            'holder' => 'required',
            'account_number' => 'required',
        ]);

        $new = new Payment();
        $new->name = $request->name;
        $new->holder = $request->holder;
        $new->account_number = $request->account_number;
        $new->type = $request->type;
        if($request->type == 'billing'){
            $new->percent = $request->percent;
        }
        if(request()->hasFile('logo')){
            $img = $request->logo;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('payments/' . $fileName, File::get($img));
            $new->logo = $fileName;
        }
        $new->save();

        $data = Payment::where('id', $new->id)->first();

        return response()->json([
            "message" => "success",
            "data" => $data
        ]);
    }

    public function create_notification(Request $request){
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $new = new Notification();
        $new->title = $request->title;
        $new->body = $request->body;
        $new->save();

        return response()->json([
            "message" => "success",
            "data" => $new
        ]);
    }

    public function setting(Request $request){   
        $min_amount = $request->min_amount;
        $max_amount = $request->max_amount;
        $odd = $request->odd;
        $overall = $request->overall_amount;

        $in_link = $request->in_link;
        $out_link = $request->out_link;

        $title = $request->title;
        $description = $request->description;
        $version_code = $request->version_code;
        $version_name = $request->version_name;
        $force = $request->force_update;

        $title_crypto = $request->title_crypto;
        $description_crypto = $request->description_crypto;
        $version_code_crypto = $request->version_code_crypto;
        $version_name_crypto = $request->version_name_crypto;
        $force_crypto = $request->force_update_crypto;

        $setting = Setting::where('id', 1)->first();
        if(empty($setting)){
            $new = new Setting();
            $new->min_amount = $min_amount;
            $new->max_amount = $max_amount;
            $new->odd = $odd;
            $new->overall_amount = $overall;
            $new->title = $title;
            $new->description = $description;
            $new->version_code = $version_code;
            $new->version_name = $version_name;
            $new->title_crypto = $title_crypto;
            $new->description_crypto = $description_crypto;
            $new->version_code_crypto = $version_code_crypto;
            $new->version_name_crypto = $version_name_crypto;
            $new->in_link = $in_link;
            $new->out_link = $out_link;
            if($force_crypto == 'on'){
                $new->force_update_crypto = 1;
            } else {
                $new->force_update_crypto = 0;
            }
            $new->save();
        } else {
            $setting->min_amount = $min_amount;
            $setting->max_amount = $max_amount;
            $setting->odd = $odd;
            $setting->overall_amount = $overall;
            $setting->title = $title;
            $setting->description = $description;
            $setting->version_code = $version_code;
            $setting->version_name = $version_name;
            $setting->in_link = $in_link;
            $setting->out_link = $out_link;
            if($force == 'on'){
                $setting->force_update = 1;
            } else {
                $setting->force_update = 0;
            }
            $setting->title_crypto = $title_crypto;
            $setting->description_crypto = $description_crypto;
            $setting->version_code_crypto = $version_code_crypto;
            $setting->version_name_crypto = $version_name_crypto;
            if($force_crypto == 'on'){
                $setting->force_update_crypto = 1;
            } else {
                $setting->force_update_crypto = 0;
            }
            $setting->save();
        }
        
        $sections = Section::get();
        

        foreach($sections as $section){
            $closestart = $section->id . '_close_start';
            $section_close_start = date('H:i:s', strtotime($request->input($closestart)));
            $closeend = $section->id . '_close_end';
            $section_close_end = date('H:i:s', strtotime($request->input($closeend)));
            $section->close_start_time = $section_close_start;
            $section->close_end_time = $section_close_end;
            $section->save();
        }     

        return response()->json([
            "message" => "success"
        ]);
    }

    public function multiple_amounts(Request $request){
        $numbers = $request->numbers;
        $date = date('Y-m-d', strtotime($request->query('date')));
        $sec = $request->query('section');
        $section = date('h:i A', strtotime($sec));
        if(strpos($numbers, ',') !== false){
            $explode = explode(',', $numbers);
            foreach($explode as $ex){
                $define = DefineAmount::where('date', $date)->where('section', $section)->where('number', $ex)->first();
                if(!empty($define)){
                    $define->hot_amount = $request->hot_amount;
                    $define->save();
                } else {
                    $new = new DefineAmount();
                    $new->number = $ex;
                    $new->section = $section;
                    $new->date = $date;
                    $new->hot_amount = $request->hot_amount;
                    $new->save();
                }
            }    
        } else {
            $define = DefineAmount::where('date', $date)->where('section', $section)->where('number', $numbers)->first();
            if(!empty($define)){
                $define->hot_amount = $request->hot_amount;
                $define->save();
            } else {
                $new = new DefineAmount();
                $new->number = $numbers;
                $new->section = $section;
                $new->date = $date;
                $new->hot_amount = $request->hot_amount;
                $new->save();
            }
        }
       
        return response()->json([
            "message" => "success"
        ]);
    }

    public function create_banner(Request $request){
        $new = new BannerSupport();
        if($request->has('file')){
            $img = $request->file;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('banners/' . $fileName, File::get($img));
            $new->img = $fileName;
        }
        $new->type = 'banner';
        $new->save();
        return response()->json([
            "message" => "success"
        ]);
    }

    public function create_support(Request $request){
        $new = new BannerSupport();
        if($request->has('file')){
            $img = $request->file;
            $fileName = $img->getClientOriginalName();
            Storage::disk('public')->put('supports/' . $fileName, File::get($img));
            $new->img = $fileName;
        }
        $new->body = $request->body;
        $new->name = $request->name;
        $new->type = 'support';
        $new->save();

        return response()->json([
            "message" => "success"
        ]);
    }

    public function create_marque(Request $request){
        $new = new BannerSupport();
        $new->body = $request->body;
        $new->type = 'marque';
        $new->save();

        return response()->json([
            "message" => "success"
        ]);
    }
}
