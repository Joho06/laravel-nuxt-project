<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use GuzzleHttp\Client;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->weather = app(WeatherService::class)->getWeather($user->latitude, $user->longitude);
        }

        return response()->json($users);
    }

    public function getWeather(User $user)
    {

        if ($user->temperature && $user->condition) {
            return response()->json([
                'temperature' => $user->temperature,
                'condition' => $user->condition,
            ]);
        }


        $client = new Client();
        $response = $client->get("https://api.openweathermap.org/data/2.5/weather?lat={$user->latitude}&lon={$user->longitude}&appid=YOUR_API_KEY&units=metric");

        $data = json_decode($response->getBody(), true);

        $temperature = $data['main']['temp'] ?? null;
        $condition = $data['weather'][0]['description'] ?? null;

        return response()->json([
            'temperature' => $temperature,
            'condition' => $condition,
        ]);
    }
}
