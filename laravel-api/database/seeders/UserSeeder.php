<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use GuzzleHttp\Client;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $client = new Client();
        $apiKey = env('OPENWEATHER_API_KEY'); // Obtener clave API desde .env

        foreach (range(1, 20) as $index) {
            $latitude = $faker->latitude();
            $longitude = $faker->longitude();

            try {
                // Llamar a la API del clima
                $response = $client->get("https://api.openweathermap.org/data/2.5/weather", [
                    'query' => [
                        'lat' => $latitude,
                        'lon' => $longitude,
                        'appid' => $apiKey,
                        'units' => 'metric'
                    ]
                ]);

                $data = json_decode($response->getBody(), true);
                $temperature = $data['main']['temp'] ?? null;
                $condition = $data['weather'][0]['description'] ?? null;
            } catch (\Exception $e) {
                // Si hay error con la API, asignar valores nulos
                $temperature = null;
                $condition = null;
            }

            // Crear el usuario con los datos generados
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'temperature' => $temperature,
                'condition' => $condition,
            ]);
        }
    }
}
