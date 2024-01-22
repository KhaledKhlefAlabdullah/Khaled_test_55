<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StakeholderController;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\RegistrationRequestController;

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


Route::apiResources([
    'pages' => \App\Http\Controllers\PageController::class,
    'contact_us_messages' => \App\Http\Controllers\ContactUsMessageController::class,
], [
    'except' => ['edit', 'create'],
//    'middleware' => ['auth:sanctum', ],
]);



Route::group(['prefix' => 'stakeholders'], function () {

    Route::get('/', [StakeholderController::class, 'index']);

    Route::post('/add', [StakeholderController::class, 'store']);

    Route::post('/edit', [StakeholderController::class, 'update']);

    Route::post('/delete', [StakeholderController::class, 'destroy']);

});

Route::group(['prefix' => 'registration_requests'], function(){

    Route::get('/',[RegistrationRequestController::class,'index']);

    Route::post('/add',[RegistrationRequestController::class,'store']);

    Route::post('/accept_or_failed',[RegistrationRequestController::class,'accept_or_failed']);

    Route::post('/delete',[RegistrationRequestController::class,'destroy']);

});


Route::get('users',[UserController::class,'index'])->name('users');

require __DIR__.'/auth.php';
