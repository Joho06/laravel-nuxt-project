<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Services\WeatherService;
use GuzzleHttp\Client;
use Tests\TestCase;

class WeatherServiceTest extends TestCase
{
    public function testWeatherService()
    {
        $weatherService = new WeatherService(new Client());
        $result = $weatherService->getWeather(40.7128, -74.0060); // Coordenadas de Nueva York

        $this->assertArrayHasKey('temperature', $result);
        $this->assertArrayHasKey('condition', $result);
        $this->assertArrayHasKey('humidity', $result);
        $this->assertArrayHasKey('wind', $result);
    }
}
