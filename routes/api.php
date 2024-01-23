<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AgentController;
use App\Http\Controllers\General\GetDataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'create_user']);
Route::post('login', [AuthController::class, 'log_in']);
Route::post('login/agent', [AgentController::class, 'agent_login']);

Route::middleware('auth:sanctum')->group( function () {
    Route::post('cashin/{id}', [AuthController::class, 'cash_in']);
    Route::post('cashout/{id}', [AuthController::class, 'cash_out']);
    Route::get('cashin-payments', [AuthController::class, 'cash_in_payments']);
    Route::get('cashout-payments', [AuthController::class, 'cash_out_payments']);
    Route::get('closetimes', [AuthController::class, 'closetime']);
    Route::post('bet', [AuthController::class, 'bet']);
    Route::get('bet-histories', [AuthController::class, 'bethistory']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('profile', [AuthController::class, 'profile_update']);
    Route::get('cash-history', [AuthController::class, 'cash_history']);
    Route::get('d-amounts', [AuthController::class, 'define_amounts']);
    Route::get('banner-support', [AuthController::class, 'bannersupport']);
    Route::post('device-token', [AuthController::class, 'device_token']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('winners', [AuthController::class, 'winners']);
    Route::post('check-password', [AuthController::class, 'check_password']);
    Route::get('agent-profile', [AgentController::class, 'agent_profile']);
    Route::post('agent-profile-update', [AgentController::class, 'agent_profile_update']);
    Route::get('agent-bets', [AgentController::class, 'agent_bet_slips']);
    Route::get('agent-cashout', [AgentController::class, 'agent_cashout']);
    Route::get('agent-users', [AgentController::class, 'agent_users']);
    Route::post('agent-create-users', [AgentController::class, 'agente_create_user']);
});

Route::get('version-update', [AuthController::class, 'version_update']);
Route::get('luckynumber', [GetDataController::class, 'luckynumber']);
Route::get('noti-test', [GetDataController::class, 'noti_test']);
