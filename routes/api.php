<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactUsMessageController;
use App\Http\Controllers\DamController;
use App\Http\Controllers\DisasterReportController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IndustrialAreaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MonitoringPointController;
use App\Http\Controllers\NaturalDisasterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationsSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParticipatingEntityController;
use App\Http\Controllers\PortalSettingsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\TimelineEventController;
use App\Http\Controllers\TimelineQuirieController;
use App\Http\Controllers\TimelineSharesRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\Portal_manager_middleware;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function () {
    // Pages
    Route::apiResource('pages', PageController::class);
//    Route::prefix('pages')->group(function () {
//        Route::get('/', 'index')->name('pages.index');
//    });

    // Contact Us Messages
    Route::apiResource('contact-us-messages', ContactUsMessageController::class);

    // Categories
    Route::apiResource('categories', CategoriesController::class);

    // Chats
    Route::apiResource('chats', ChatController::class);

    // Messages
    Route::apiResource('messages', MessageController::class)->except(['index']);

    // Show messages by chat ID
    Route::prefix('messages')->group(function () {
        Route::get('/get/{chat_id}', [MessageController::class, 'showMessagesByChatId'])->name('messages.showMessagesByChatId');
    });


    // Dams
    Route::apiResource('dams', DamController::class);

    // Disaster Reports
    Route::apiResource('disaster-reports', DisasterReportController::class);


    // Entities
    Route::apiResource('entities', EntityController::class);

    // Files
    Route::apiResource('files', FileController::class);


    // Industrial Areas
//    Route::apiResource('industrial-areas', IndustrialAreaController::class);

    // Monitoring Points
    Route::apiResource('monitoring-points', MonitoringPointController::class);

    // Natural Disasters
    Route::apiResource('natural-disasters', NaturalDisasterController::class);

    // Notifications
    Route::apiResource('notifications', NotificationController::class);

    // Notification Settings
    Route::apiResource('notification-settings', NotificationsSettingController::class);

    // Participating Entities
    Route::apiResource('participating-entities', ParticipatingEntityController::class);

    // Portal Settings
    Route::apiResource('portal-settings', PortalSettingsController::class);

    // Posts
    Route::apiResource('posts', PostController::class);

    // Services
    Route::apiResource('services', ServiceController::class);

    // Shipments
    Route::apiResource('shipments', ShipmentController::class);

    // Suppliers
    Route::apiResource('suppliers', SupplierController::class);

    // Employees
    Route::apiResource('employees', EmployeeController::class);

    // Timelines
    Route::apiResource('timelines', TimelineController::class);

    // Timeline Events
    Route::apiResource('timeline-events', TimelineEventController::class);

    // Timeline Queries
    Route::apiResource('timeline-queries', TimelineQuirieController::class);

    // Timeline Shares Requests
    Route::apiResource('timeline-shares-requests', TimelineSharesRequestController::class);

    // User Profiles
    Route::apiResource('user-profiles', UserProfileController::class);

});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::middleware([Portal_manager_middleware::class])->group(function () {

        Route::group(['prefix' => 'industrial-areas'], function () {

            Route::get('/', [IndustrialAreaController::class, 'index']);

            Route::get('/details', [IndustrialAreaController::class, 'show']);

            Route::post('/add', [IndustrialAreaController::class, 'store']);

            Route::post('/edite', [IndustrialAreaController::class, 'update']);

        });

    });


});


Route::group(['prefix' => 'stakeholders'], function () {

    Route::get('/', [StakeholderController::class, 'index']);

    Route::post('/add', [StakeholderController::class, 'store']);

    Route::post('/edit', [StakeholderController::class, 'update']);

    Route::post('/delete', [StakeholderController::class, 'destroy']);

});

Route::group(['prefix' => 'registration_requests'], function () {

    Route::get('/', [RegistrationRequestController::class, 'index']);

    Route::post('/add', [RegistrationRequestController::class, 'store']);

    Route::post('/accept_or_failed', [RegistrationRequestController::class, 'accept_or_failed']);

    Route::post('/delete', [RegistrationRequestController::class, 'destroy']);

});

Route::post('/add', [RegistrationRequestController::class, 'store']);


Route::get('users', [UserController::class, 'index'])->name('users');

require __DIR__ . '/auth.php';
