<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StakeholderController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\RegiatrationRequestController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('/pages', \App\Http\Controllers\PageController::class);



Route::group(['prefix' => 'stakeholders'], function () {

    Route::get('/', [StakeholderController::class, 'index']);

    Route::post('/add', [StakeholderController::class, 'store']);

    Route::post('/edit', [StakeholderController::class, 'update']);

    Route::post('/delete', [StakeholderController::class, 'destroy']);

});

Route::group(['prefix' => 'registration_requests'], function(){

    Route::get('/',[RegiatrationRequestController::class,'index']);

    Route::post('/add',[RegiatrationRequestController::class,'store']);

    Route::post('/delete',[RegiatrationRequestController::class,'destroy']);

});


Route::get('users',[UserController::class,'index'])->name('users');

require __DIR__.'/auth.php';
