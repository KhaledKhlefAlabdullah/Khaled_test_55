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
    Route::apiResource('pages', PageController::class)->except(['create', 'edit']);
//    Route::prefix('pages')->group(function () {
//        Route::get('/', 'index')->name('pages.index');
//    });

    // Contact Us Messages
    Route::apiResource('contact-us-messages', ContactUsMessageController::class)->except(['create', 'edit']);

    // Categories
    Route::apiResource('categories', CategoriesController::class)->except(['create', 'edit']);

    // Chats
    Route::apiResource('chats', ChatController::class)->except(['create', 'edit']);

    // Messages
    Route::apiResource('messages', MessageController::class)->except(['index', 'create', 'edit']);

    // Show messages by chat ID
    Route::prefix('messages')->group(function () {
        Route::get('/get/{chat_id}', [MessageController::class, 'showMessagesByChatId'])->name('messages.showMessagesByChatId');
    });


    // Dams
    Route::apiResource('dams', DamController::class)->except(['create', 'edit']);

    // Disaster Reports
    Route::apiResource('disaster-reports', DisasterReportController::class)->except(['create', 'edit']);

    // Employees
    Route::apiResource('employees', EmployeeController::class)->except(['create', 'edit']);

    // Entities
    Route::apiResource('entities', EntityController::class)->except(['create', 'edit']);

    // Files
    Route::apiResource('files', FileController::class)->except(['create', 'edit']);

    // Industrial Areas
    Route::apiResource('industrial-areas', IndustrialAreaController::class)->except(['create', 'edit']);

    // Monitoring Points
    Route::apiResource('monitoring-points', MonitoringPointController::class)->except(['create', 'edit']);

    // Natural Disasters
    Route::apiResource('natural-disasters', NaturalDisasterController::class)->except(['create', 'edit']);

    // Notifications
    Route::apiResource('notifications', NotificationController::class)->except(['create', 'edit']);

    // Notification Settings
    Route::apiResource('notification-settings', NotificationsSettingController::class)->except(['create', 'edit']);

    // Participating Entities
    Route::apiResource('participating-entities', ParticipatingEntityController::class)->except(['create', 'edit']);

    // Portal Settings
    Route::apiResource('portal-settings', PortalSettingsController::class)->except(['create', 'edit']);

    // Posts
    Route::apiResource('posts', PostController::class)->except(['create', 'edit']);

    // Services
    Route::apiResource('services', ServiceController::class)->except(['create', 'edit']);

    // Shipments
    Route::apiResource('shipments', ShipmentController::class)->except(['create', 'edit']);

    // Suppliers
    Route::apiResource('suppliers', SupplierController::class)->except(['create', 'edit']);

    // Timelines
    Route::apiResource('timelines', TimelineController::class)->except(['create', 'edit']);

    // Timeline Events
    Route::apiResource('timeline-events', TimelineEventController::class)->except(['create', 'edit']);

    // Timeline Queries
    Route::apiResource('timeline-queries', TimelineQuirieController::class)->except(['create', 'edit']);

    // Timeline Shares Requests
    Route::apiResource('timeline-shares-requests', TimelineSharesRequestController::class)->except(['create', 'edit']);

    // User Profiles
    Route::apiResource('user-profiles', UserProfileController::class)->except(['create', 'edit']);

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


Route::get('users', [UserController::class, 'index'])->name('users');

require __DIR__ . '/auth.php';
