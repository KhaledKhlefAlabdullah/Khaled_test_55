<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;

class MapController extends Controller
{
    public function index()
    {
        try {
            $locations = [
                ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
                ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
                ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
                // Add more locations as needed
            ];

            $mapUrl = route('map');

            $filePath = public_path('images/reports/map_screenshot.png');

            Browsershot::url($mapUrl)
                ->setNodeBinary('C:/Program Files/nodejs/node.exe')
                ->setTempDir('C:/temp') // Set the temporary directory explicitly
                ->save($filePath);

            return view('map', compact('locations', 'mapUrl'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
