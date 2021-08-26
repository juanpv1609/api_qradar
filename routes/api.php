<?php

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OfensesController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\Auth\LoginController;


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





// Route::middleware('api')->get('user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api')->group(function () {
    Route::get('user', function (Request $request) {
        return $request->user();
    });
    Route::get('actualUser', [UserController::class,'actualUser']);

    Route::post('login', [LoginController::class,'login']);
    Route::post('logout', [LoginController::class,'logout']);



    Route::resource('usuarios', UserController::class);
    Route::resource('company', CompanyController::class);
    Route::resource('rules', RulesController::class);


    Route::get('usuarios-all', [UserController::class,'indexAll']);
    Route::post('usuario-updatePassword', [UserController::class,'usuarioUpdatePassword']);
    Route::get('top-ofenses-categories', [OfensesController::class,'getOffenses']);
    Route::get('top-logsources-events', [OfensesController::class,'topLogSourceEvents']);
    Route::get('source-address', [OfensesController::class,'sourceAddress']);
    Route::get('local-destination', [OfensesController::class,'localDestination']);
    Route::get('offenses-rule/{qid}', [OfensesController::class,'offensesRule']);






});

