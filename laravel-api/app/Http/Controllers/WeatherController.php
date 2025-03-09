<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeather($lat, $lon)
    {

        $apiKey = env('OPENWEATHER_API_KEY');
        $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";

        $response = file_get_contents($url);
        $data = json_decode($response, true);

        return response()->json([
            'temperature' => $data['main']['temp'],
            'condition' => $data['weather'][0]['description'],
            'humidity' => $data['main']['humidity'],
            'wind' => $data['wind']['speed'],
        ]);
    }
}
