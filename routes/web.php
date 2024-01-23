<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\General\TableController;
use App\Http\Controllers\General\CreateController;
use App\Http\Controllers\General\UpdateController;
use App\Http\Controllers\General\ApproveController;
use App\Http\Controllers\General\GetDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::controller(RouteController::class)->group(function () {
    Route::get('/agent','agent')->name('agent');
    Route::get('/lucky-number','luckynumber')->name('luckynumber');
    Route::get('/cash','cash')->name('cash');
    Route::get('/customers','customers')->name('customers');
    Route::get('/block-number','blocknumber')->name('blocknumber');
    Route::get('/notification','notification')->name('notification');
    Route::get('/payment-method','payment')->name('payment');
    Route::get('/slips-arrange','slip_arrange')->name('slips-arrange');
    Route::get('/setting','setting')->name('setting');
    Route::get('/banner-support','bannersupport')->name('bannersupport');
    Route::get('/terms', function(){
        return view('terms');
    });
});

Route::controller(TableController::class)->group(function () {
    Route::get('/get_agents','agents');
    Route::get('/get_customers','customers');
    Route::get('/get_lucky_numbers','lucky_numbers');
    Route::get('/get_cash','cash');
    Route::get('/get_notifications','notification');
    Route::get('/get_blocknumbers','block_numbers');
    Route::get('/get_payments','payment');
    Route::get('/get_banners','banners');
    Route::get('/get_supports','supports');
    Route::get('/get_marques','marques');
    Route::get('/get_hots','hots');
    Route::get('/get_block_dash','blocksdash');
});

Route::controller(CreateController::class)->group(function () {
    Route::post('/create-agent','create_agent');
    Route::post('/create-customer','create_customer');
    Route::post('/create-block','create_block');
    Route::post('/block-multiple','multiple_block');
    Route::post('/create-payment','create_payment');
    Route::post('/create-notification','create_notification');
    Route::post('/setting','setting');
    Route::post('/multiple-amounts','multiple_amounts');
    Route::post('/create-banner','create_banner');
    Route::post('/create-support','create_support');
    Route::post('/create-marque','create_marque');
});

Route::controller(UpdateController::class)->group(function () {
    Route::post('/ban-agent/{id}','ban_agent');
    Route::post('/delete-agent/{id}','delete_agent');
    Route::post('/ban-user/{id}','ban_user');
    Route::post('/delete-user/{id}','delete_user');
    Route::post('/delete-block/{id}','delete_block');
    Route::post('/delete-payment/{id}','delete_payment');
    Route::get('/total-users','gettotal_users');
    Route::get('/total-agents','gettotal_agents');
    Route::get('/total-cashin','gettotal_cashin');
    Route::get('/total-cashout','gettotal_cashout');
    Route::get('/in-status/{id}','payment_in_status');
    Route::get('/out-status/{id}','payment_out_status');
    Route::get('/update-define','change_define_amount');
    Route::post('/edit-agent/{id}','edit_agent');
    Route::post('/edit-customer/{id}','edit_customer');
    Route::post('/edit-block/{id}','edit_block');
    Route::post('/edit-payment/{id}','edit_payment');
    Route::post('/edit-banner/{id}','edit_banner');
    Route::post('/edit-support/{id}','edit_support');
    Route::post('/edit-marque/{id}','edit_marque');
    Route::post('/delete-banner/{id}','delete_banner');
    Route::post('/delete-support/{id}','delete_support');
    Route::post('/delete-marque/{id}','delete_marque');
    Route::post('/delete-hot','delete_hot');
    Route::get('/blast/{id}','blast_noti');
    Route::post('/cashout-agent/{id}','cashoutagent');
    Route::post('/cashin-customer/{id}','cashincustomer');
    Route::post('/cashout-customer/{id}','cashoutcustomer');
});

Route::controller(ApproveController::class)->group(function () {
    Route::get('/cashin-approve/{id}','cashin_approve');
    Route::get('/cashin-reject/{id}','cashin_reject');
    Route::get('/cashout-approve/{id}','cashout_approve');
    Route::get('/cashout-reject/{id}','cashout_reject');
});

Route::controller(GetDataController::class)->group(function () {
    Route::get('/get-numbers','get_numbers');
    Route::get('/get-defineamounts','get_define_amount');
    Route::get('/get-slips','slips');
    Route::get('/get-slip-details','getslipdetail');
    Route::get('/get-statics','statics');
    Route::post('/section-clear','clearance');
    Route::post('/section-refund','refunds');
    Route::get('/get-histories','get_histories');
    Route::get('/get-cashout-detail/{id}','get_cashout_detail');
    Route::get('/get-detail-histories','get_detail_hisotries');
    Route::get('/get-arrange-statics','get_arrange_statics');
    // Route::get('/get-winners','getwinners');
    Route::post('/store-admin-token','storeadmintoken')->name('store.admintoken');
});