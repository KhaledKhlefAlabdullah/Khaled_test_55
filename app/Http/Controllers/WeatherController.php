<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use function App\Helpers\api_response;

class WeatherController extends Controller
{
    public function getWeatherData(){
        try{

            $weather = Http::get('https://data.tmd.go.th/api/WeatherToday/V2/?uid=api&ukey=api12345', [
                'uid' => 'api',
                'ukey' => 'api12345'
            ]);
            $xml = $weather->getBody()->getContents();

            $array = json_decode(json_encode(simplexml_load_string($xml)), true); // Convert XML to an array
            $json = json_encode($array, JSON_PRETTY_PRINT); 
            return api_response(data:$array,message:'getting-weather-data-success');
        }
        catch(Exception $e){
            return api_response(errors:$e->getMessage(),message:'getting-weather-data-error',code:500);
        }
    }
}
