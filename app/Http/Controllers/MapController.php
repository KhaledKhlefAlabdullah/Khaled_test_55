<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class MapController extends Controller
{
    public function index()
    {
        $locations = [
            ['name' => 'Location 1', 'latitude' => 40.7128, 'longitude' => -74.0060],
            ['name' => 'Location 2', 'latitude' => 40.7306, 'longitude' => -73.9352],
            ['name' => 'Location 3', 'latitude' => 40.7484, 'longitude' => -73.9857]
            // Add more locations as needed
        ];

        $mapUrl = route('map');
        $filePath = public_path('images/map_screenshot.png');

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
