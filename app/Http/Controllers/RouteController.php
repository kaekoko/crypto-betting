<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\BannerSupport;
use Illuminate\Support\Facades\DB;

class RouteController extends Controller
{
    public function agent(){
        return view('project.agent');
    }

    public function luckynumber(){
        return view('project.luckynumber');
    }

    public function customers(){
        return view('project.customers');
    }

    public function cash(){
        return view('project.cash');
    }

    public function notification(){
        return view('project.notification');
    }

    public function blocknumber(){
        $sections = Section::get();
        return view('project.blocknumber', compact('sections'));
    }

    public function payment(){
        return view('project.payment');
    }

    public function setting(){
        $setting = Setting::first();
        $sections = DB::table('sections')->get();
        return view('project.setting', compact('setting','sections'));
    }

    public function bannersupport(){
        $banners = BannerSupport::where('type', 'banner')->get();
        $supports = BannerSupport::where('type', 'support')->get();
        return view('project.bannersupport', compact('banners', 'supports'));
    }

    public function slip_arrange(){
        $sections = Section::get();
        return view('project.bet_histories', compact('sections'));
    }
}
