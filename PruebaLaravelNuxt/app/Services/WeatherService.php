<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{


public function getWeather($lat, $lon)
{
    $cacheKey = "weather_{$lat}_{$lon}";

    return Cache::remember($cacheKey, now()->addMinutes(60), function () use ($lat, $lon) {
        $apiKey = env('OPENWEATHER_API_KEY');
        $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric";

        $response = Http::get($url);

        if ($response->successful()) {
            $data = $response->json();
            return [
                'temperature' => $data['main']['temp'] ?? null,
                'condition' => $data['weather'][0]['description'] ?? 'Desconocido',
                'humidity' => $data['main']['humidity'] ?? null,
                'wind' => $data['wind']['speed'] ?? null,
            ];
        }

        return ['error' => 'No se pudo obtener los datos del clima'];
    });
}


}
