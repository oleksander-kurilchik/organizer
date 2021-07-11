<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('sanctum')->namespace('\App\Http\Controllers\Api\Auth')->group(function() {
    Route::post('token', 'LoginController@login')->name('login');
    Route::post('registration', 'RegisterController@registration')->name('registration');
    Route::post('logout', 'LoginController@logout')->name('logout')->middleware('auth:sanctum');
});

Route::group(['middleware'=>['auth:sanctum']],function (){
    Route::resource('events', \App\Http\Controllers\EventsController::class)->parameters([
        'events' => 'id'
    ]);
});

