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
    'categories' => \App\Http\Controllers\CategoriesController::class,
    'chats' => \App\Http\Controllers\ChatController::class,
    'dams' => \App\Http\Controllers\DamController::class,
    'disaster_reports' => \App\Http\Controllers\DisasterReportController::class,
    'employees' => \App\Http\Controllers\EmployeeController::class,
    'entities' => \App\Http\Controllers\EntityController::class,
    'files' => \App\Http\Controllers\FileController::class,
    'industrial_areas' => \App\Http\Controllers\IndustrialAreaController::class,
    'messages' => \App\Http\Controllers\MessageController::class,
    'monitoring_points' => \App\Http\Controllers\MonitoringPointController::class,
    'natural_disasters' => \App\Http\Controllers\NaturalDisasterController::class,
    'notifications' => \App\Http\Controllers\NotificationController::class,
    'notification_settings' => \App\Http\Controllers\NotificationsSettingController::class,
    'participating_entities' => \App\Http\Controllers\ParticipatingEntityController::class,
    'portal_settings' => \App\Http\Controllers\PortalSettingsController::class,
    'posts' => \App\Http\Controllers\PostController::class,
//    'registration_requests' => RegistrationRequestController::class,
    'services' => \App\Http\Controllers\ServiceController::class,
    'shipments' => \App\Http\Controllers\ShipmentController::class,
//    'stakeholders' => StakeholderController::class,
    'suppliers' => \App\Http\Controllers\SupplierController::class,
    'timelines' => \App\Http\Controllers\TimelineController::class,
    'timeline_events' => \App\Http\Controllers\TimelineEventController::class,
    'timeline_quires' => \App\Http\Controllers\TimelineQuirieController::class,
    'timeline_shares_requests' => \App\Http\Controllers\TimelineSharesRequestController::class,
    'user_profiles' => \App\Http\Controllers\UserProfileController::class,

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
