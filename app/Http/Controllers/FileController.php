<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use App\Http\Resources\FileResource;
use App\Models\Category;
use App\Models\File;
use App\Models\Stakeholder;
use App\Models\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function App\Helpers\api_response;
use function App\Helpers\edit_file;
use function App\Helpers\getAndCheckModelById;
use function App\Helpers\getIdByName;
use function App\Helpers\getMediaType;
use function App\Helpers\stakeholder_id;
use function App\Helpers\store_files;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\Process\Process;

class FileController extends Controller
{
    /**
     * Retrieve and paginate Manuals_And_Plans files.
     *
     * This function fetches files of type 'Manuals & Plans' from the database,
     * paginates the results, and transforms the file data using the specified
     * resource class before returning it.
     *
     */
    public function view_Manuals_And_Plans()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-4466554400MP']);
    }

    /**
     * Get the educational files
     */
    public function view_educational_files()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-44665544EDU']);
    }

    /**
     * Get the educational file versions
     */
    public function view_educational_files_versions(string $version_id)
    {
        try {

            $files = File::where(['version_id' => $version_id])->join('categories', 'categories.id', '=', 'files.sub_category_id')->when(Auth::check(), function ($query) {
                return $query->addSelect('files.id', 'categories.id as category_id', 'categories.name as ctegory', 'files.title', 'files.description', 'files.version', 'files.media_url', 'files.created_at');
            }, function ($query) {
                return $query->addSelect('files.id', 'categories.name as ctegory', 'files.title', 'files.description', 'files.version', 'files.created_at');
            })->orderBy('files.created_at', 'desc')->get();


            return api_response($files, 'educational-file-versions-getting-success');
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'educational-file-versions-getting-error', code: 500);
        }
    }

    /**
     * Get the Guide lines files
     */
    public function view_guidelines_and_updates()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-44665544GAU']);
    }

    /**
     * Get my Guide lines files
     */
    public function view_my_guidelines_and_updates()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-44665544GAU', 'files.user_id' => Auth::id()]);
    }

    /**
     * Get view infrastructure service reports files
     */
    public function view_infrastructure_service_reports()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-44665544ISR']);
    }

    /**
     * Get my water level files
     */
    public function view_water_level_reports()
    {
        return $this->get_files(['main_category_id' => '003e8400-e29b-41d4-a716-44665544WLR']);
    }

    /**
     * Get files
     */
    public function get_files(array $Conditions)
    {
        try {

            $files = File::where($Conditions)->join('categories', 'categories.id', '=', 'files.sub_category_id')
            ->leftJoin('user_profiles','files.user_id','=','user_profiles.user_id')
            ->when(Auth::check(), function ($query) {
                return $query->addSelect('files.id', 'categories.id as category_id', 'categories.name as ctegory', 'user_profiles.name as Auther','files.title', 'files.description', 'files.media_url', 'files.update_state as state', 'files.created_at');
            }, function ($query) {
                return $query->addSelect('files.id', 'categories.name as ctegory', 'user_profiles.name as Auther','files.title', 'files.description', 'files.created_at');
            })->get();

            return api_response($files, 'files-getting-success');
        } catch (Exception $e) {

            return api_response(message: 'files-getting-error', errors: [$e->getMessage()], code: 500);
        }
    }


    /**
     * Download files
     */
    public function download_file(string $id)
    {

        try {

            $file = getAndCheckModelById(File::class, $id);

            return response()->download(public_path($file->media_url));
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], code: 500, message: 'download-error');
        }
    }

    /**
     * Download BCP Checklist
     */
    public function download_checklist()
    {

        try {
            return response()->download(public_path('files/BCP/Business_Continuity_Plan_Checklist.docx'));
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], code: 500, message: 'download-error');
        }
    }

      /**
     * Download BCP Checklist
     */
    public function download_templet()
    {

        try {
            return response()->download(public_path('files/BCP/Reference_BCP.docx'));
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], code: 500, message: 'download-error');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get files by auth user ID
        $files = File::where('user_id', auth()->user()->id)->get();

        return ($files->count() == 1)
            ? new FileResource($files->first())
            : FileResource::collection($files);
    }

    /**
     * Add Manuals_And_Plans
     */
    public function add_Manuals_And_Plans(FileRequest $request)
    {
        return $this->store($request, 'Manuals_And_Plans');
    }

    /**
     * Add educational files
     */
    public function add_educational_files(FileRequest $request)
    {
        return $this->store($request, 'Education');
    }

    /**
     * Add Guidelines and updates files
     */
    public function add_guidelines_and_updates_files(FileRequest $request)
    {
        return $this->store($request, 'Guideline_And_Updates');
    }

    /**
     * Add Infrastructure service report file
     */
    public function add_nfrastructure_services_report_file(FileRequest $request)
    {
        return $this->store($request, 'Infrastructure_Reports');
    }

    /**
     * Add water level report file
     */
    public function add_water_level_report_file(FileRequest $request)
    {
        return $this->store($request, 'Water_Level_Reports');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request, $file_type)
    {
        try {

            $request->validated();

            $file = $request->file;
 
            $main_category_id = getIdByName(Category::class, $file_type);

            $path = store_files($file, '/files/' . $file_type);

           if ($file_type == 'Education') {
                $version = $request->input('version');
            } else {
                $version = null;
            }

            if($file_type == 'Guideline_And_Updates'){
                $sub_category_id = getIdByName(Category::class,'File');
            }else{
                $sub_category_id = $request->input('category_id');
            }
            
            File::create([
                'user_id' => Auth::id(),
                'main_category_id' => $main_category_id,
                'sub_category_id' => $sub_category_id,
                'title' => $request->input('title'),
                'tags' => $request->has('tags') ? $request->input('tags') : null,
                'description' => $request->input('description'),
                'version' => $version,
                'media_url' => $path,
                'media_type' => getMediaType($file),
                'update_frequency' => $request->has('update_frequency') ? $request->input('update_frequency') : null

            ]);


            return api_response(message: 'file-adding-success');
        } catch (Exception $e) {

            return api_response(errors: [$e->getMessage()], message: 'file-adding-error', code: 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get file by ID
        $file = File::find($id);

        // Check if file exists
        if (!$file) {
            return response()->json(['message' => 'File not found'], 404);
        }

        return new FileResource($file);
    }


    /**
     * edit Manuals_And_Plans
     */
    public function edit_Manuals_And_Plans(FileRequest $request, string $id)
    {
        return $this->update($request, 'Manuals_And_Plans', $id);
    }

    /**
     * edit educational files
     */
    public function edit_educational_files(FileRequest $request, string $id)
    {
        return $this->update($request, 'Educational', $id);
    }

    /**
     * edit Guideline_And_Updates files
     */
    public function edit_guidelines_and_updates_files(FileRequest $request, string $id)
    {
        return $this->update($request, 'Guideline_And_Updates', $id);
    }

    /**
     * edit Guideline_And_Updates files
     */
    public function update_guidelines_and_updates_files(FileRequest $request, string $id)
    {
        try {

            // Get file by ID
            $file_ = getAndCheckModelById(File::class, $id);

            if ($request->hasFile('file')) {

                $newFile = $request->file('file');

                // Process and store the new file
                $path = '/files/Guideline_And_Updates';

                $file_path = edit_file($file_->media_url, $newFile, $path);
            } else {
                // Keep the existing file path if no new file is uploaded
                $file_path = $file_->media_url;
            }

            $file_->update([
                'media_url' => $file_path,
            ]);

            return api_response(message: 'update-Guideline-And-Updates-success');
        } catch (Exception $e) {

            return api_response(errors: [$e->getMessage()], message: 'update-Guideline_And_Updates-error', code: 500);
        }
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $request, string $file_type, string $id)
    {
        try {

            $request->validated();

            // Get file by ID
            $file_ = getAndCheckModelById(File::class, $id);

            $file_path = $file_->media_url;

            if ($request->hasFile('file')) {

                $newFile = $request->file('file');

                // Process and store the new file
                $path = '/files/' . $file_type;

                $file_path = edit_file($file_->media_url, $newFile, $path);

                $file_type = getMediaType($newFile);
            } else {
                // Keep the existing file path if no new file is uploaded
                $file_path = $file_->media_url;

                $file_type = $file_->file_type;
            }

            $file_->update([
                'sub_category_id' => $request->input('category_id'),
                'file_type' => $file_type,
                'title' => $request->input('title'),
                'tags' => $request->has('tags') ? $request->input('tags') : null,
                'description' => $request->input('description'),
                'version' => $request->input('version'),
                'media_url' => $file_path,
                'media_type' => $file_type,
                'update_frequency' => $request->has('update_frequency') ? $request->input('update_frequency') : null
            ]);


            return api_response(message: 'file-editing-success');
        } catch (Exception $e) {

            return api_response(errors: [$e->getMessage()], message: 'file-editing-error', code: 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Get file by ID
        $file = getAndCheckModelById(File::class, $id);

        // Check if file exists
        if (!$file) {
            return api_response(message: 'File not found', code: 404);
        }

        // Check if user is authorized
        if ($file->user_id != Auth::id()) {
            return api_response(message: 'Unauthorized to delete this file it\'s dont belong to you', code: 401);
        }

        // todo add this in evere object has any type of media to remove it from the app
        unlink(public_path($file->media_url));

        // Delete file
        $file->delete();

        return api_response(message: 'file-delete-success');
    }

    /**
     * Generet reports pdf files
     */
    public function generate_pdf()
    {
        try {

            $templateProcessor = new TemplateProcessor(public_path('files/ReportsTemplet/companyReport.docx'));

            $templateProcessor->setValues(
                array(
                    'company_name' => 'ss',
                    'date' => 'ss',
                    'company_operational_status' => 'ss',
                    'monitoring_graphs' => 'ss',
                    'production_sites' => 'ss',
                    'Suppliers' => 'ss',
                    'Employees' => 'ss',
                    'Shipments' => 'ss',
                    'Wastes' => 'ss',
                    'infrastructure_services_status' => 'ss'
                )
            );

            $data = [
                ['station' => 'C.2, Nakhonsawan Province', 'discharge' => '> 3,590', 'water_level' => '> 556', 'crisis_point' => '09/12 - 1,783'],
                ['station' => 'Chaopraya Dam', 'discharge' => '> 2,840', 'water_level' => '> 2.00', 'crisis_point' => '09/13 - 1,851'],
                ['station' => 'RAMA VI Dam', 'discharge' => '', 'water_level' => '', 'crisis_point' => 'Yesterday - 1,698'],
                ['station' => 'C.54, Samutprakran Province', 'discharge' => '', 'water_level' => '', 'crisis_point' => 'Today - 1,799'],
            ];

            $rows = '';
            foreach ($data as $row) {
                $rows .= "<w:tr><w:tc><w:p><w:r><w:t>{$row['station']}</w:t></w:r></w:p></w:tc><w:tc><w:p><w:r><w:t>{$row['discharge']}</w:t></w:r></w:p></w:tc><w:tc><w:p><w:r><w:t>{$row['water_level']}</w:t></w:r></w:p></w:tc><w:tc><w:p><w:r><w:t>{$row['crisis_point']}</w:t></w:r></w:p></w:tc></w:tr>";
            }

            $templateProcessor->setValue('table_data', $rows);

            $templateProcessor->saveAs('files/ReportsTemplet/companyReport_updated.docx');
            // $templateProcessor->setImageValue('map_image', array('path' => public_path('/images/profile_images/defualt_user_avatar.png'), 'width' => 100, 'height' => 100));

            // return response()->download('files/ReportsTemplet/companyReport.docx');
            // $templateProcessor->saveAs('files/ReportsTemplet/companyReport.pdf');

            // Download the generated PDF
            return response()->download('files/ReportsTemplet/companyReport.pdf')->deleteFileAfterSend(true);
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'report-generatting-error', code: 500);
        }
    }

    /**
     * Get report information details
     */
    public function get_info()
    {
        try {

            $name = UserProfile::where('user_id', Auth::id())->first()->name;
            $company_state = Stakeholder::findOrFail(stakeholder_id())->tenant_company_state;

            $info = [
                'company_name' => $name,
                'date' => now()->format('d/m/y'),

                //3- Map image: displaying the company's production sites and flood water level in the surrounding area
                'map_image' => '',

                //4- Company operational status: Operating,Evacuating, Trapped or Evacuated

                'company_operational_status' => $company_state,

                //5- Monitoring graphs: displaying water level in monitoring points and dams (observation + prediction) example
                'monitoring_graphs' => '',

                //6.1.Production sites: Safe Production sites - Not Safe Production Sites- Impacted Date
                'production_sites' => '',

                //6.2.Suppliers: Material : Safe suppliers - Not Safe suppliers - Impacted date
                'Suppliers' => '',

                //6.3.Employees: Department : Safe Staff+leaders - Not Safe Staff +Leaders - Impacted Date
                'Employees' => '',

                //6.4.Shipments: Product : Safe Customers - Not Safe Customers
                'Shipments' => '',

                //6.5. Wastes: Safe Wastes - Not Safe Wastes - Impacted Date
                'Wastes' => '',


                //7.1. Service name - Status (available,partially interrupted , interrupted) - Stop date -Start date - Last updated"					
                'infrastructure_services_status' => ''
            ];

            return $info;
        } catch (Exception $e) {
            return api_response(errors: [$e->getMessage()], message: 'getting-report-info-erroe', code: 500);
        }
    }

    public function get_map_image()
    {

        $locations = [
            ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
            ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
            ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
            // Add more locations as needed
        ];

        $mapUrl = route('map');
        $filePath = public_path('images/reports/map_screenshot.png');

        $command = "node public/js/map_imag.js $mapUrl $filePath";
        $process = Process::fromShellCommandline($command);
        $process->run();

        if ($process->isSuccessful()) {
            return view('map', compact('locations', 'mapUrl'));
        } else {
            return "Failed to capture map screenshot";
        }
    }
}
