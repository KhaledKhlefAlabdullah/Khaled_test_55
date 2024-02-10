<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteController;

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

Route::group(['prefix' => 'api'], function () {

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
        //    Route::apiResource('files', FileController::class);

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

        // Timelines
        Route::apiResource('timelines', TimelineController::class)->except(['update', 'show']);

        // Timelines Events
        Route::apiResource('timeline-events', TimelineEventController::class);

        // Timelines Queries
        Route::apiResource('timeline-queries', TimelineQuiresController::class)->except(['update']);

        // Timelines Shares Requests
        Route::apiResource('timeline-shares-requests', TimelineSharesRequestController::class);

        // User Profiles
        //    Route::apiResource('user-profiles', UserProfileController::class);

    });

    Route::middleware(['auth:sanctum'])->group(function () {

        // Routes for portal manager role
        Route::middleware(['portal-manger'])->group(function () {

            Route::post('edite-about-us-posts-details/{id}', [PageController::class, 'edite_about_us_post_details']);

            Route::post('edite-contact-us-details', [PageController::class, 'edite_contact_us_details']);

            Route::post('edite-project-description/{id}', [PostController::class, 'edite_project_description']);

            Route::group(['prefix' => 'industrial-areas'], function () {

                Route::get('/details', [IndustrialAreaController::class, 'show']);

                Route::post('/add', [IndustrialAreaController::class, 'store']);

                Route::post('/edite/{id}', [IndustrialAreaController::class, 'update']);

            });

            // for add new general news
            Route::group(['prefix' => 'general-news'], function () {

                Route::post('/add', [PostController::class, 'new_general_news']);

                Route::put('/edite/{id}', [PostController::class, 'edite_general_news']);

                Route::delete('/delete/{id}', [PostController::class, 'delete_general_news']);

            });

        });

        // Routes for industrial area representative role
        Route::middleware(['industrial-area-representative'])->group(function () {

            Route::group(['prefix' => 'subdomain-users'], function () {

                Route::get('/', [UserController::class, 'subdomain_users']);

                Route::post('/add', [UserController::class, 'store_new_subdomain_user']);

                Route::get('/details', [UserController::class, 'subdomain_user_details']);

                Route::post('/delete', [UserController::class, 'destroy']);

            });

            // Services
            Route::group(['prefix' => 'services'], function () {

                Route::get('/', [ServiceController::class, 'index']);

                Route::post('/add', [ServiceController::class, 'store']);

                Route::post('/edite', [ServiceController::class, 'update']);

            });

            Route::group(['prefix' => 'registration_requests'], function () {

                Route::get('/', [RegistrationRequestController::class, 'index']);

                Route::get('/details', [RegistrationRequestController::class, 'show']);

                Route::post('/accept_or_failed', [RegistrationRequestController::class, 'accept_or_failed']);

                Route::post('/delete', [RegistrationRequestController::class, 'destroy']);

            });

        });

        // Routes for industrial area representative role
        Route::middleware(['infrastructure-provider'])->group(function () {

        });

        // Routes for industrial area representative role
        Route::middleware(['tenant-company'])->group(function () {

            Route::post('change-status', [StakeholderController::class, 'edit_company_state']);

            // View list of Manuals and plans
            Route::get('/manuals-and-plans', [FileController::class, 'view_manuals_and_plans'])->name('file.view_manuals_and_plans');
        });

        Route::middleware(['Industrial-area-or-government-representative'])->group(function () {

            // Add Manuals & Plans
            Route::post('/manuals-and-plans/add', [FileController::class, 'add_manuals_and_plans'])->name('file.add_manuals_and_plans');

            // for main monitoring points
            Route::group(['prefix' => 'main-monitoring-points'], function () {

                Route::get('/', [MonitoringPointController::class, 'view_monitoring_points']);

                Route::post('/add', [MonitoringPointController::class, 'add_main_monitoring_point']);

                Route::put('/edite/{id}', [MonitoringPointController::class, 'edite_monitoring_point_details']);

                Route::delete('/delete/{id}', [MonitoringPointController::class, 'destroy']);

            });

        });

        // Routes for industrial area representative role
        Route::middleware(['government-representative'])->group(function () {

        });

        // Routes for all users expect Portal manager role
        Route::middleware(['all-users-expect-portal-manager'])->group(function () {

            // For profile functions
            Route::group(['prefix' => 'profile'], function () {

                Route::get('/', [UserProfileController::class, 'show']);

                Route::post('/edite', [UserProfileController::class, 'update']);

            });

            // Fill contact us form
            Route::post('contact-us-registered', [ContactUsMessageController::class, 'store_registered']);

        });

        // Routes for just infrastructure provider and tenant company
        Route::middleware(['infrastructure-provider-or-tenant-company'])->group(function () {

            // Employees
            Route::group(['prefix' => 'employees'], function () {

                Route::get('/', [EmployeeController::class, 'index']);

                Route::get('/get-csv', [EmployeeController::class, 'export_csv_employees_file']);

                Route::post('/upload-csv', [EmployeeController::class, 'import_csv_employees_file']);

                Route::post('add', [EmployeeController::class, 'store']);

                Route::put('edite', [EmployeeController::class, 'update']);

                Route::delete('delete', [EmployeeController::class, 'destroy']);

            });

            // Suppliers
            Route::group(['prefix' => 'suppliers'], function () {

                Route::get('/', [SupplierController::class, 'index']);

                Route::post('/add-supplier', [SupplierController::class, 'store']);

                Route::post('/edite-supplier', [SupplierController::class, 'update']);

                Route::delete('/delete-supplier', [SupplierController::class, 'update']);

            });

            // Routes
            Route::group(['prefix' => 'routes'], function () {

                Route::get('/', [EntityController::class, 'get_routes']);

                Route::post('/add', [EntityController::class, 'add_new_route']);

                Route::put('/edite/{id}', [EntityController::class, 'edite_route_details']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });

            // Production Sites
            Route::group(['prefix' => 'production-sites'], function () {

                Route::get('/', [EntityController::class, 'production_sites']);

                Route::post('/add', [EntityController::class, 'add_new_production_site']);

                Route::put('/edite/{id}', [EntityController::class, 'edite_production_site']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });

            // Customers routes
            Route::group(['prefix' => 'customers'], function () {

                Route::get('/', [EntityController::class, 'get_Customers']);

            });

            // Wastes Routes
            Route::group(['prefix' => 'wastes'], function () {

                Route::get('/', [WasteController::class, 'index']);

                Route::post('/add', [WasteController::class, 'store']);

                Route::put('/edite/{id}', [WasteController::class, 'update']);

                Route::delete('/delete/{id}', [WasteController::class, 'destroy']);

            });

        });

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

        Route::post('change-password', [AuthenticatedSessionController::class, 'change_password']);

    });

    // public routes

    // get al industrial areas
    Route::get('industrial-areas', [IndustrialAreaController::class, 'index']);

    // send registration request
    Route::post('registration_requests/add-register', [RegistrationRequestController::class, 'store']);

    // get all general news
    Route::get('general-news', [PostController::class, 'view_general_news']);

    // project description
    Route::get('project-description', [PostController::class, 'view_project_description']);

    // View contact us details
    Route::get('contact-us-details', [PageController::class, 'contact_us_details']);

    // View about us details
    Route::get('about-us-details', [PageController::class, 'about_us_page_details']);

    // Fill contact us form
    Route::post('contact-us-unregistered', [ContactUsMessageController::class, 'store_unregistered']);

    require __DIR__ . '/auth.php';
});
//Route::group(['prefix' => 'stakeholders'], function () {
//
//    Route::get('/', [StakeholderController::class, 'index']);
//
//    Route::post('/add', [StakeholderController::class, 'store']);
//
//    Route::post('/edit', [StakeholderController::class, 'update']);
//
//    Route::post('/delete', [StakeholderController::class, 'destroy']);
//
//});


// todo we have to use the functions to shortest the code
