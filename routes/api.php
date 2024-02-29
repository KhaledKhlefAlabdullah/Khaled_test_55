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
use App\Http\Controllers\MaterialController;
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
        //Route::apiResource('monitoring-points', MonitoringPointController::class);

        // Natural Disasters
        Route::apiResource('natural-disasters', NaturalDisasterController::class);

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

            Route::post('edit-about-us-posts-details/{id}', [PageController::class, 'edit_about_us_post_details']);

            Route::post('edit-contact-us-details', [PageController::class, 'edit_contact_us_details']);

            Route::post('edit-project-description/{id}', [PostController::class, 'edit_project_description']);

            Route::group(['prefix' => 'educational-files'], function(){

                Route::post('/add',[FileController::class,'add_educational_files']);

                Route::post('/edit/{id}',[FileController::class,'edit_educational_files']);

                Route::delete('/delete/{id}',[FileController::class,'destroy']);

            });

            Route::group(['prefix' => 'industrial-areas'], function () {

                Route::post('/add', [IndustrialAreaController::class, 'store']);

                Route::get('/details/{id}', [IndustrialAreaController::class, 'show']);


                Route::put('/edit/{id}', [IndustrialAreaController::class, 'update']);

            });

            // for add new general news
            Route::group(['prefix' => 'general-news'], function () {

                Route::post('/add', [PostController::class, 'new_general_news']);

                // put request type post
                Route::post('/edit/{id}', [PostController::class, 'edit_general_news']);

                Route::delete('/delete/{id}', [PostController::class, 'delete_general_news']);

            });

        });

        // Routes for industrial area representative role
        Route::middleware(['industrial-area-representative'])->group(function () {

            Route::group(['prefix' => 'subdomain-users'], function () {

                Route::get('/', [UserController::class, 'subdomain_users']);

                Route::post('/add', [UserController::class, 'store_new_subdomain_user']);

                Route::get('/details/{id}', [UserController::class, 'subdomain_user_details']);

                Route::delete('/delete/{id}', [UserController::class, 'destroy']);

            });

            // Services
            Route::group(['prefix' => 'services'], function () {

                Route::get('/', [ServiceController::class, 'index']);

                Route::post('/add', [ServiceController::class, 'store']);

                Route::post('/edit', [ServiceController::class, 'update']);

            });

            Route::group(['prefix' => 'registration-requests'], function () {

                Route::get('/', [RegistrationRequestController::class, 'index']);

                Route::get('/details/{id}', [RegistrationRequestController::class, 'show']);

                Route::post('/accept_or_failed/{id}', [RegistrationRequestController::class, 'accept_or_failed']);

                Route::delete('/delete/{id}', [RegistrationRequestController::class, 'destroy']);

            });

        });

        // Routes for iftrastructure provider role
        Route::middleware(['infrastructure-provider'])->group(function () {

        });

        // Routes for tenant company role
        Route::middleware(['tenant-company'])->group(function () {

            Route::post('change-status', [StakeholderController::class, 'edit_company_state']);

            // View list of Manuals and plans
            Route::get('/manuals-and-plans', [FileController::class, 'view_manuals_and_plans'])->name('file.view_manuals_and_plans');
        });

        // Routes for industrial area representative and Government representative
        Route::middleware(['Industrial-area-or-government-representative'])->group(function () {

            // Manuals & Plans
            Route::group(['prefix' => 'manuals-and-plans'],function(){

                Route::post('/add', [FileController::class, 'add_manuals_and_plans']);

                Route::post('/edit/{id}', [FileController::class, 'edit_manuals_and_plans']);

                Route::delete('/delete/{id}', [FileController::class, 'destroy']);

            });

            // for main monitoring points
            Route::group(['prefix' => 'main-monitoring-points'], function () {

                Route::get('/', [MonitoringPointController::class, 'view_monitoring_points']);

                Route::post('/add', [MonitoringPointController::class, 'add_monitoring_point']);

                Route::put('/edit/{id}', [MonitoringPointController::class, 'edit_monitoring_point_details']);

                Route::delete('/delete/{id}', [MonitoringPointController::class, 'destroy']);

            });


            // Announcements Start
            Route::group(['prefix' => 'announcements'], function () {

                // View list of Announcements
                // View announcements list (publisher-published date-content )
                Route::get('/view-list-of-announcements', [PostController::class, 'view_list_of_announcements']);

                // View list of my Announcements
                // View my Announcements list (content-last published date)
                Route::get('/view-list-of-my-announcements', [PostController::class, 'view_list_of_my_announcements']);


            });
            // Announcements End

        });

        // Routes for industrial area representative role
        Route::middleware(['government-representative'])->group(function () {

        });

        // Routes for all users expect Portal manager role
        Route::middleware(['all-users-expect-portal-manager'])->group(function () {

            // For profile functions
            Route::group(['prefix' => 'profile'], function () {

                Route::get('/', [UserProfileController::class, 'show']);

                Route::post('/edit', [UserProfileController::class, 'update']);

            });

            // Fill contact us form
            Route::post('contact-us-registered', [ContactUsMessageController::class, 'store_registered']);

            // View manuals and plans
            Route::get('/manuals-and-plans', [FileController::class,'view_manuals_and_plans']);
        });

        // Routes for just infrastructure provider and tenant company
        Route::middleware(['infrastructure-provider-or-tenant-company'])->group(function () {

            // Employees
            Route::group(['prefix' => 'employees'], function () {

                Route::get('/', [EmployeeController::class, 'index']);

                Route::get('/related-info', [EmployeeController::class, 'get_info']);

                Route::get('/get-csv', [EmployeeController::class, 'export_csv_employees_file']);

                Route::post('/upload-csv', [EmployeeController::class, 'import_csv_employees_file']);

                Route::get('/get-ifo',[EmployeeController::class,'get_info']);

                Route::post('/add', [EmployeeController::class, 'store']);

                Route::put('/edit/{id}', [EmployeeController::class, 'update']);

                Route::delete('/delete/{id}', [EmployeeController::class, 'destroy']);

            });

            // Suppliers
            Route::group(['prefix' => 'suppliers'], function () {

                Route::get('/', [SupplierController::class, 'index']);

                Route::post('/add', [SupplierController::class, 'store']);

                Route::put('/edit/{id}', [SupplierController::class, 'update']);

                Route::delete('/delete/{id}', [SupplierController::class, 'destroy']);

            });

            // Materials
            Route::group(['prefix' => 'materials'], function () {

                Route::get('/', [EntityController::class, 'get_materials']);

                Route::post('/add', [EntityController::class, 'add_new_material']);
            });

            // Routes
            Route::group(['prefix' => 'routes'], function () {

                Route::get('/', [EntityController::class, 'get_routes']);

                Route::post('/add', [EntityController::class, 'add_new_route']);

                Route::put('/edit/{id}', [EntityController::class, 'edit_route_details']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });

            // Production Sites
            Route::group(['prefix' => 'production-sites'], function () {

                Route::get('/', [EntityController::class, 'production_sites']);

                Route::post('/add', [EntityController::class, 'add_new_production_site']);

                Route::put('/edit/{id}', [EntityController::class, 'edit_production_site']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });

            // Customers routes
            Route::group(['prefix' => 'customers'], function () {

                Route::get('/', [EntityController::class, 'get_customers']);

                Route::post('/add', [EntityController::class, 'add_customer']);

                Route::put('/edit/{customer_id}/{shipment_id}', [EntityController::class, 'edit_customer']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });


            // Products routes
            Route::group(['prefix' => 'products'], function () {

                Route::get('/',[EntityController::class,'get_products']);

            });

            // Wastes Routes
            Route::group(['prefix' => 'wastes'], function () {

                Route::get('/', [WasteController::class, 'index']);

                Route::get('/disposal-sites',[WasteController::class,'get_desposal_locations']);

                Route::post('/add', [WasteController::class, 'store']);

                Route::put('/edit/{id}', [WasteController::class, 'update']);

                Route::delete('/delete/{id}', [WasteController::class, 'destroy']);

            });

            // for custom monitoring points
            Route::group(['prefix' => 'custom-monitoring-points'], function () {

                Route::post('/add', [MonitoringPointController::class, 'add_monitoring_point']);

                Route::put('/edit/{id}', [MonitoringPointController::class, 'edit_monitoring_point_details']);

                Route::delete('/delete/{id}', [MonitoringPointController::class, 'destroy']);

            });

            // for notifications settings
            Route::group(['prefix' => 'notifications-settings'], function () {

                Route::get('/', [NotificationsSettingController::class, 'index']);

                Route::put('/edit/{id}', [NotificationsSettingController::class, 'update']);

            });

        });


        // For all authenticated users
        Route::group(['prefix' => 'notifications'],function(){

            Route::get('/',[NotificationController::class,'index']);

            Route::put('/marked-read/{id}',[NotificationController::class,'marked_as_read']);

            Route::delete('/delete/{id}',[NotificationController::class,'destroy']);

        });

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

        Route::post('change-password', [AuthenticatedSessionController::class, 'change_password']);

        Route::get('/educational-files',[FileController::class,'view_educational_files']);

        Route::get('/download-educational-file/{id}',[FileController::class,'download_files']);

    });

    // public routes

    // get al industrial areas
    Route::get('industrial-areas', [IndustrialAreaController::class, 'index']);

    // send registration request
    Route::post('registration-requests/add-register', [RegistrationRequestController::class, 'store']);

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

    // View list of educational files
    Route::get('/educational-files',[FileController::class,'view_educational_files']);

    require __DIR__ . '/auth.php';

});


