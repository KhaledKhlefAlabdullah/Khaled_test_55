<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\File;

class MapController extends Controller
{
    public function index()
    {
        try {

             // Render the Blade template to HTML
         // Render the Blade template to HTML
         $html = View::make('map', [
            'locations' => [
                ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
                ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
                ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
            ]
        ])->render();

        // Define the output directory
        $outputDirectory = public_path('images/reports');
        
        // Create the output directory if it doesn't exist
        if (!File::isDirectory($outputDirectory)) {
            File::makeDirectory($outputDirectory, 0755, true, true);
        }

        // Convert HTML to image using wkhtmltoimage
        $outputImagePath = $outputDirectory . '/map_image.png';
        $command = "wkhtmltoimage --format png -q -o \"$outputImagePath\" - \"$html\"";
        exec($command, $output, $returnCode);

        // Now the HTML template should be converted to an image
        return response()->file($outputImagePath);
        // Now the HTML template should be converted to an image
    
            // $locations = [
            //     ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
            //     ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
            //     ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
            //     // Add more locations as needed
            // ];

            // $mapUrl = route('map');

            // $filePath = public_path('images/reports/map_screenshot.png');

            // Browsershot::url($mapUrl)
            //     ->setNodeBinary('C:/Program Files/nodejs/node.exe')
            //     ->setNpmBinary('C:/Program Files/nodejs/npm')
            //     ->setTempDir(public_path('images/temp')) // Set the temporary directory explicitly
            //     ->save($filePath);

            // return view('map', compact('locations', 'mapUrl'));
        } catch (Exception $e) {
            return "5555555".$e->getMessage()."555555";
        }
    }
}
