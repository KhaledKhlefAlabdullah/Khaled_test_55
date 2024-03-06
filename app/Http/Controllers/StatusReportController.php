<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function App\Helpers\api_response;

class StatusReportController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate_preview_status_report()
    {
        return api_response();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function select_displayed_sections_in_report()
    {
        return api_response();
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function download_status_report()
    {
        return api_response();

    }

}
