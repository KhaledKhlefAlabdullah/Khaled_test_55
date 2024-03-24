<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;

class MapController extends Controller
{
    public function index()
    {
        try {

            
            // Define the output directory
            $outputImagePath = public_path('images/reports/map_image.png');

            $snappy = App::make('snappy.image');
            
            $html = view('map', [
                'locations' => [
                    ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
                    ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
                    ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
                ]
            ])->render();
            $snappy->setOption('format', 'png');
            $snappy->setOption('width',1); // FOR IMAGE WIDTH SET
            // Generate image from HTML
            $snappy->generateFromHtml($html, $outputImagePath);

            // Now the HTML template should be converted to an image
            //        return response()->file($outputImagePath);
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
            return $e->getMessage();
        }
    }
}
