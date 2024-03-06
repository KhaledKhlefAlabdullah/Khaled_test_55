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
use App\Http\Controllers\Timelines\TimelineController;
use App\Http\Controllers\Timelines\TimelineEventController;
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

            // For News
            Route::group(['prefix' => 'news'], function () {

                Route::post('/add', [PostController::class, 'add_news']);

                Route::post('/edit/{id}', [PostController::class, 'edit_news']);

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

            // For timelines
            Route::group(['prefix' => 'timelines'],function(){

                // For View my timeline and the shared timelines
                Route::get('/shared',[TimelineController::class,'index']);

                // For view the compaies in same industrial area
                Route::get('/companie',[TimelineSharesRequestController::class,'get_companies_in_same_industrial_area']);

                Route::group(['prefix' => 'share-requests'],function(){

                    // Get the share request
                    Route::get('/',[TimelineSharesRequestController::class,'index']);

                    // To send share timeline request
                    Route::post('/send',[TimelineSharesRequestController::class,'store']);

                    // To send share timeline request
                    Route::put('/accept-reject/{share_request_id}',[TimelineSharesRequestController::class,'accept_reject']);

                });

                // For Events
                Route::group(['prefix' => 'events'],function(){

                    Route::get('/{id}',[TimelineEventController::class,'show']);

                });

            });


            Route::group(['prefix' => 'status-report', 'controller' => \App\Http\Controllers\StatusReportController::class], function () {
                // Generate & Preview Status report
                /**
                 * I want to Generate a report that includes all details about my company status including:
                 * 1- Company Name
                 * 2- Date
                 * 3- Map image: displaying the company's production sites and flood water level in the surrounding area
                 * 4- Company operational status: Operating,Evacuating, Trapped or Evacuated
                 * 5- Monitoring graphs: displaying water level in monitoring points and dams (observation + prediction) example
                 * 6- Business Resources:
                 * 6.1.Production sites: Safe Production sites - Not Safe Production Sites- Impacted Date
                 * 6.2.Suppliers: Material : Safe suppliers - Not Safe suppliers - Impacted date
                 * 6.3.Employees: Department : Safe Staff+leaders - Not Safe Staff +Leaders - Impacted Date
                 * 6.4.Shipments: Product : Safe Customers - Not Safe Customers
                 * 6.5. Wastes: Safe Wastes - Not Safe Wastes - Impacted Date
                 * 7- Infrastructure Services Status:
                 * 7.1. Service name - Status (available,partially interrupted , interrupted) - Stop date -Start date - Last updated
                 */
                Route::get('generate-preview-status-report', 'generate_preview_status_report');


                // Select displayed sections in Status Report
                /**
                 * I want to Check/Uncheck sections that are going to be displayed status report which includes:
                 * 1- Monitoring
                 * 1.1.Monitoring points
                 * 1.2. Dams
                 * 2. Business Recources
                 * 2.1. Production site
                 * 2.2. Employees
                 * 2.3. Suppliers
                 * 2.4. Shipments
                 * 2.5. Wastes
                 * 3. Infrastructure Services Status
                 */
                Route::get('select-displayed-sections-in-report', 'select_displayed_sections_in_report');


                // Download Status Report
                // Download Generated Status report as a PDF
                Route::get('download-status-report', 'download_status_report');
            });
        });

        // Routes for Government representative role
        Route::middleware(['government-representative'])->group(function () {

        });

        // Routes for industrial area representative and Government representative
        Route::middleware(['Industrial-area-or-government-representative'])->group(function () {

            // Manuals & Plans
            Route::group(['prefix' => 'manuals-and-plans'], function () {

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

        // Routes for all users except Portal manager role
        Route::middleware(['all-users-except-portal-manager'])->group(function () {

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

                Route::get('/{id}', [PostController::class, 'show']);

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

            // For News
            Route::group(['prefix' => 'news'], function () {

                Route::get('/', [PostController::class, 'view_news']);

                Route::get('/detailes/{id}', [PostController::class, 'show']);

                Route::post('/search/{query}', [PostController::class, 'search_news']);

            });

            Route::group(['prefix' => 'connect'], function () {

                Route::get('/', [PostController::class, 'view_posts']);

                Route::post('/search/{query}', [PostController::class, 'search_posts']);

                Route::post('/add', [PostController::class, 'add_posts']);

                Route::post('/edit/{id}', [PostController::class, 'edit_posts']);

                Route::delete('/delete/{id}', [PostController::class, 'destroy']);

                Route::post('/filtering', [PostController::class, 'filtering_posts']);

                Route::post('/upvot/{id}', [PostController::class, 'upvot_posts']);

                Route::get('/users-profiles', [UserController::class, 'same_subdomain_users']);

            });

            // View Announcements
            Route::group(['prefix' => 'announcements'], function () {
                // View Announcements
                Route::get('/view-announcements', [AnnouncementsController::class, 'view_announcements']);
            });

            // To get the related categories
            Route::group(['prefix' => 'categories'],function(){

                Route::get('/manuals-and-plans', [CategoriesController::class, 'get_manula_and_plans_categories']);

                Route::get('/events', [CategoriesController::class, 'get_events_categories']);

            });
        });

        // Routes for just infrastructure provider and tenant company
        Route::middleware(['infrastructure-provider-or-tenant-company'])->group(function () {

            // Employees
            Route::group(['prefix' => 'employees', 'controller' => EmployeeController::class], function () {

                Route::get('/', 'index');

                Route::get('/related-info', 'get_info');

                Route::get('/get-csv', 'export_csv_employees_file');

                Route::post('/upload-csv', 'import_csv_employees_file');

                Route::get('/get-ifo', 'get_info');

                Route::post('/add', 'store');

                Route::put('/edit/{id}', 'update');

                Route::delete('/delete/{id}', 'destroy');

                // View Employees details on map
                // View Employees details
                Route::get('view-employees-details', 'view_employees_details');

                // View the current status of the Employees
                // TODO: This case needs a flood api
                Route::get('view-current-status-employees', 'view_current_status_employees');

                // View the future status of the Employees | View the expected status for the Employees
                // TODO: This case needs a flood api
                Route::get('view-future-status-employees', 'view_future_status_employees');
            });

            // Suppliers
            Route::group(['prefix' => 'suppliers', 'controller' => SupplierController::class], function () {

                // View Supplier details
                // View Supplier details (Supplier ID- Supplier location - Used supply routes) on map or not map
                Route::get('/', 'index');

                Route::post('/add', 'store');

                Route::put('/edit/{id}', 'update');

                Route::delete('/delete/{id}', 'destroy');

                // View the current status of the Supplier
                // TODO: This case needs a flood api
                Route::get('view-current-status-suppliers', 'view_current_status_suppliers');

                // View the future status of the supplier
                // TODO: This case needs a flood api
                Route::get('view-future-status-suppliers', 'view_future_status_suppliers');


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
            Route::group(['prefix' => 'production-sites', 'controller' => EntityController::class], function () {
                // View my production sites details
                Route::get('/', 'production_sites');

                // View the current status of the Production site
                // TODO: This case needs a flood api
                Route::get('/view-status-production-site', 'view_status_production_site');

                // View the future status of the Production site
                // View the expected status of the Production site
                // TODO: This case needs a flood api
                Route::get('/view-future-status-production-site', 'view_future_status_production_site');

                Route::post('/add', 'add_new_production_site');

                Route::put('/edit/{id}', 'edit_production_site');

                Route::delete('/delete/{id}', 'destroy');

            });

            // Shipping || Shipment
            Route::group(['prefix' => 'shipping', 'controller' => ShippingController::class], function () {
                // View Shipping details
                // View Shipping details(Customer ID - Customer location -used shipping routes) on map
                Route::get('view-shipping-details', 'view_shipping_details');

                // View the current status of the Shipping
                Route::get('view-status-shipping/{id}', 'view_status_shipping');

                // View the future status of the Shipping
                // View the expected status for the Shipping
                // TODO: This case needs a flood api
                Route::get('view-future-status-shipping', 'view_future_status_shipping');
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
            Route::group(['prefix' => 'wastes', 'controller' => WasteController::class], function () {

                // View waste details
                // View waste disposal details ( waste ID,used routes , disposal location) on map
                Route::get('/', 'index');

                Route::get('/disposal-sites', 'get_desposal_locations');

                Route::post('/add', 'store');

                Route::put('/edit/{id}', 'update');

                Route::delete('/delete/{id}', 'destroy');

                // View the current status of the waste
                // TODO: This case needs a flood api
                Route::get('view-current-status-wastes', 'view_current_status_wastes');

                // View the future status of the waste
                // TODO: This case needs a flood api
                Route::get('view-future-status-wastes', 'view_future_status_wastes');

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
