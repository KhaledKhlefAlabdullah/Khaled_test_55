<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportController extends Controller
{
    public function generateReport()
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Create an array of page data for each page in the report
        $pages = [
            ['view' => 'report-page-1', 'data' => ['title' => 'Page 1 Title', 'content' => 'Page 1 content']],
            ['view' => 'report-page-2', 'data' => ['title' => 'Page 2 Title', 'content' => 'Page 2 content']],
            // Add more pages as needed
        ];

        foreach ($pages as $page) {
            $html = view($page['view'], $page['data'])->render();
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait'); // يمكنك تغيير الاتجاه حسب الصفحة
            $dompdf->render();
        }

        return $dompdf->stream('multi-page_report.pdf');
    }
}
