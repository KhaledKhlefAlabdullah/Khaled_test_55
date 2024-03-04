<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactUsMessageController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\IndustrialAreaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MonitoringPointController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Notification\NotificationsSettingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegistrationRequestController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\StakeholderController;
use App\Http\Controllers\SupplierController;
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

        // Routes for portal manager role
        Route::middleware(['portal-manger'])->group(function () {

            Route::post('edit-about-us-posts-details/{id}', [PageController::class, 'edit_about_us_post_details']);

            Route::post('edit-contact-us-details', [PageController::class, 'edit_contact_us_details']);

            Route::post('edit-project-description/{id}', [PostController::class, 'edit_project_description']);

            Route::group(['prefix' => 'educational-files'], function () {

                Route::post('/add', [FileController::class, 'add_educational_files']);

                Route::post('/edit/{id}', [FileController::class, 'edit_educational_files']);

                Route::delete('/delete/{id}', [FileController::class, 'destroy']);

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

            // For registration requests
            Route::group(['prefix' => 'registration-requests'], function () {

                Route::get('/', [RegistrationRequestController::class, 'index']);

                Route::get('/details/{id}', [RegistrationRequestController::class, 'show']);

                Route::post('/accept_or_failed/{id}', [RegistrationRequestController::class, 'accept_or_failed']);

                Route::delete('/delete/{id}', [RegistrationRequestController::class, 'destroy']);

            });

            // For articles
            Route::group(['prefix' => 'articles'], function () {

                Route::post('/add', [PostController::class, 'add_article']);

                Route::delete('/delete/{id}', [PostController::class, 'destroy']);

            });

        });

        // Routes for infrastructure provider role
        Route::middleware(['infrastructure-provider'])->group(function () {

            Route::group(['prefix' => 'infrastructure-services-reports'], function () {

                Route::post('/upload', [FileController::class, 'add_nfrastructure_services_report_file']);

                Route::delete('/delete/{id}', [FileController::class, 'destroy']);

            });

        });

        // Routes for tenant company role
        Route::middleware(['tenant-company'])->group(function () {

            Route::post('change-status', [StakeholderController::class, 'edit_company_state']);

            // View list of Manuals and plans
            Route::get('/manuals-and-plans', [FileController::class, 'view_manuals_and_plans'])->name('file.view_manuals_and_plans');
        });

        // Routes for Government representative role
        Route::middleware(['government-representative'])->group(function () {

        });

        // Routes for industrial area representative and Government representative
        Route::middleware(['Industrial-area-or-government-representative'])->group(function () {

            // Manuals & Plans
            Route::group(['prefix' => 'manuals-and-plans'], function () {


                Route::get('/categories', [CategoriesController::class, 'get_manula_and_plans_categories']);

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
                Route::get('/view-list-of-announcements', [AnnouncementsController::class, 'view_list_of_announcements']);

                // View list of my Announcements
                // View my Announcements list (content-last published date)
                Route::get('/view-list-of-my-announcements', [AnnouncementsController::class, 'view_list_of_my_announcements']);

                // Publish an Announcements
                // Publish an Announcement to be displayed to portal users
                Route::put('/publish-an-announcements', [AnnouncementsController::class, 'publish_an_announcements']);

                // edit_announcements
                Route::put('/edit-announcements/{id}', [AnnouncementsController::class, 'edit_announcements']);

                // Delete an Announcement
                Route::delete('/delete-announcements/{id}', [AnnouncementsController::class, 'delete_announcements']);
            });
            // Announcements End

            // For Guidelines and updates
            Route::group(['prefix' => 'guideline-and-updates'], function () {

                Route::get('/my', [FileController::class, 'view_my_guidelines_and_updates']);

                Route::post('/add', [FileController::class, 'add_guidelines_and_updates_files']);

                Route::post('/update/{id}', [FileController::class, 'update_guidelines_and_updates_files']);

                Route::post('/edit/{id}', [FileController::class, 'edit_guidelines_and_updates_files']);

                Route::delete('/delete/{id}', [FileController::class, 'destroy']);

            });

            // For water level reports
            Route::group(['prefix' => 'water-level-reports'], function () {

                Route::post('/upload', [FileController::class, 'add_water_level_report_file']);

                Route::delete('/delete/{id}', [FileController::class, 'destroy']);

            });

        });

        // Routes for for industrial area representative and infrastructure providerrole
        Route::middleware(['Industrail-area-representative-or-infrastructure-provider'])->group(function () {

            Route::get('download-infrastructure-sevices-reports/{id}', [FileController::class, 'download_file']);

        });

        // Routes for all users expect Portal manager role
        Route::middleware(['all-users-expect-portal-manager'])->group(function () {

            // For profile functions
            Route::group(['prefix' => 'profile'], function () {

                Route::get('/', [UserProfileController::class, 'show']);

                Route::post('/edit', [UserProfileController::class, 'update']);

            });

            // For Guidelines and updates
            Route::get('/guideline-and-updates/', [FileController::class, 'view_guidelines_and_updates']);

            // For Infrastructure services reports
            Route::get('/infrastructure-services-reports', [FileController::class, 'view_infrastructure_service_reports']);

            // Fill contact us form
            Route::post('/contact-us-registered', [ContactUsMessageController::class, 'store_registered']);

            // View manuals and plans
            Route::get('/manuals-and-plans', [FileController::class, 'view_manuals_and_plans']);

            // For water level reports
            Route::group(['prefix' => 'water-level-reports'], function () {

                Route::get('/', [FileController::class, 'view_water_level_reports']);

                Route::get('/download/{id}', [FileController::class, 'download_file']);

            });

            // For articles
            Route::group(['prefix' => 'articles'], function () {

                Route::get('/', [PostController::class, 'view_list_of_articles']);

                Route::post('/search/{query}', [PostController::class, 'search_article']);

                Route::get('/{id}', [PostController::class, 'view_article']);

            });

            Route::group(['prefix' => 'chats'], function () {

                Route::get('/', [ChatController::class, 'index']);

                // For chats messages
                Route::group(['prefix' => 'messages'], function () {

                    Route::get('/{chat_id}', [MessageController::class, 'index']);

                    Route::get('/starred/{chat_id}', [MessageController::class, 'get_starred_messages']);

                    Route::post('/search/{chat_id}/{query}', [MessageController::class, 'search_message']);

                    Route::post('/add', [MessageController::class, 'store']);

                    Route::put('/edit/{id}', [MessageController::class, 'update']);

                    Route::delete('/delete/{id}', [MessageController::class, 'destroy']);

                    Route::post('/set-starred/{message_id}', [MessageController::class, 'set_message_starred']);

                });

            });


            // View Announcements
            Route::group(['prefix' => 'announcements'], function () {
                // View Announcements
                Route::get('/view-announcements', [AnnouncementsController::class, 'view_announcements']);
            });
        });

        // Routes for just infrastructure provider and tenant company
        Route::middleware(['infrastructure-provider-or-tenant-company'])->group(function () {

            // Employees
            Route::group(['prefix' => 'employees'], function () {

                Route::get('/', [EmployeeController::class, 'index']);

                Route::get('/related-info', [EmployeeController::class, 'get_info']);

                Route::get('/get-csv', [EmployeeController::class, 'export_csv_employees_file']);

                Route::post('/upload-csv', [EmployeeController::class, 'import_csv_employees_file']);

                Route::get('/get-ifo', [EmployeeController::class, 'get_info']);

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
                // View my production sites details
                Route::get('/', [EntityController::class, 'production_sites']);

                // View the current status of the Production site
                // TODO: This case needs a flood api
                Route::get('/view-status-production-site', [EntityController::class, 'view_status_production_site']);

                // View the future status of the Production site
                // View the expected status of the Production site
                // TODO: This case needs a flood api
                Route::get('/view-future-status-production-site', [EntityController::class, 'view_future_status_production_site']);

                Route::post('/add', [EntityController::class, 'add_new_production_site']);

                Route::put('/edit/{id}', [EntityController::class, 'edit_production_site']);

                Route::delete('/delete/{id}', [EntityController::class, 'destroy']);

            });

            // Shipping || Shipment
            Route::group(['prefix' => 'shipping'], function () {
                // View Shipping details
                // View Shipping details(Customer ID - Customer location -used shipping routes) on map
                Route::get('view-shipping-details', [ShippingController::class, 'view_shipping_details']);


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

                Route::get('/', [EntityController::class, 'get_products']);

            });

            // Wastes Routes
            Route::group(['prefix' => 'wastes'], function () {

                Route::get('/', [WasteController::class, 'index']);

                Route::get('/disposal-sites', [WasteController::class, 'get_desposal_locations']);

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
        Route::group(['prefix' => 'notifications'], function () {

            Route::get('/', [NotificationController::class, 'index']);

            Route::put('/marked-read/{id}', [NotificationController::class, 'marked_as_read']);

            Route::delete('/delete/{id}', [NotificationController::class, 'destroy']);

        });

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'store']);

        Route::post('change-password', [AuthenticatedSessionController::class, 'change_password']);

        Route::get('/educational-files', [FileController::class, 'view_educational_files']);

        Route::get('/download-educational-file/{id}', [FileController::class, 'download_file']);

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
    Route::get('/educational-files', [FileController::class, 'view_educational_files']);


    require __DIR__ . '/auth.php';

});
