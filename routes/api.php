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
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Notification\NotificationsSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParticipatingEntityController;
use App\Http\Controllers\PortalSettingsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Timelines\TimelineController;
use App\Http\Controllers\Timelines\TimelineEventController;
use App\Http\Controllers\Timelines\TimelineQuiresController;
use App\Http\Controllers\Timelines\TimelineSharesRequestController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Middleware\Api\Allow_all_users_expect_portal_manager_middleware;
use App\Http\Middleware\Api\Government_representative_middleware;
use App\Http\Middleware\Api\Ifrastructar_provider_middleware;
use App\Http\Middleware\Api\Industrial_area_representative_middleware;
use App\Http\Middleware\Api\Portal_manager_middleware;
use App\Http\Middleware\Api\Tenant_company_middleware;
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
//    Route::apiResource('messages', MessageController::class)->except(['index']);

    // Messages
    Route::prefix('messages')->controller(MessageController::class)->group(function () {
        Route::get('/get/{chat_id}', 'showMessagesByChatId')->name('messages.showMessagesByChatId');
        Route::post('/', 'store')->name('messages.store');
        Route::get('/{id}', 'show')->name('messages.show');
        Route::put('/{message}', 'update')->name('messages.update');
        Route::delete('/{id}', 'destroy')->name('messages.destroy');
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
//    Route::apiResource('services', ServiceController::class);

    // Shipments
    Route::apiResource('shipments', ShipmentController::class);

    // Suppliers
    Route::apiResource('suppliers', SupplierController::class);

    // Employees
    Route::apiResource('employees', EmployeeController::class);

    // Timelines
    Route::apiResource('timelines', TimelineController::class)->except(['update', 'show']);

    // Timelines Events
    Route::apiResource('timeline-events', TimelineEventController::class);

    // Timelines Queries
    Route::apiResource('timeline-queries', TimelineQuiresController::class)->except(['update']);

    // Timelines Shares Requests
    Route::apiResource('timeline-shares-requests', TimelineSharesRequestController::class);

    // User Profiles
    Route::apiResource('user-profiles', UserProfileController::class);

});

Route::middleware(['auth:sanctum'])->group(function () {


    // Routes for portal manager role
    Route::middleware([Portal_manager_middleware::class])->group(function () {

        Route::group(['prefix' => 'industrial-areas'], function () {

            Route::get('/', [IndustrialAreaController::class, 'index']);

            Route::get('/details', [IndustrialAreaController::class, 'show']);

            Route::post('/add', [IndustrialAreaController::class, 'store']);

            Route::post('/edite', [IndustrialAreaController::class, 'update']);

        });

    });

    // Routes for industrial area representative role
    Route::middleware([Industrial_area_representative_middleware::class])->group(function () {

        Route::group(['prefix' => 'subdomain-users'], function () {

            Route::get('/', [UserController::class, 'subdomain_users']);

            Route::post('/add', [UserController::class, 'store_new_subdomain_user']);

            Route::get('/details', [UserController::class, 'subdomain_user_details']);

            Route::post('/delete', [UserController::class, 'destroy']);

        });

        Route::group(['prefix' => 'services'], function () {

            Route::get('/', [ServiceController::class, 'index']);

            Route::post('/add', [ServiceController::class, 'store']);

            Route::post('/edite', [ServiceController::class, 'update']);

        });


        Route::group(['prefix' => 'registration_requests'], function () {

            Route::get('/', [RegistrationRequestController::class, 'index']);

            Route::post('/accept_or_failed', [RegistrationRequestController::class, 'accept_or_failed']);

            Route::post('/delete', [RegistrationRequestController::class, 'destroy']);

        });

    });

    // Routes for industrial area representative role
    Route::middleware([Ifrastructar_provider_middleware::class])->group(function () {


    });

    // Routes for industrial area representative role
    Route::middleware([Tenant_company_middleware::class])->group(function () {


    });

    // Routes for industrial area representative role
    Route::middleware([Government_representative_middleware::class])->group(function () {


    });

    // Routes for all users expect Portal manager role
    Route::middleware([Allow_all_users_expect_portal_manager_middleware::class])->group(function () {

        // For profile functions
        Route::group(['prefix' => 'profile'], function () {

            Route::get('/', [UserProfileController::class, 'show']);

            Route::post('/edite', [UserProfileController::class, 'update']);

        });


    });


});


Route::group(['prefix' => 'stakeholders'], function () {

    Route::get('/', [StakeholderController::class, 'index']);

    Route::post('/add', [StakeholderController::class, 'store']);

    Route::post('/edit', [StakeholderController::class, 'update']);

    Route::post('/delete', [StakeholderController::class, 'destroy']);

});


Route::post('registration_requests/add-register', [RegistrationRequestController::class, 'store']);


Route::get('users', [UserController::class, 'index']);


require __DIR__ . '/auth.php';
