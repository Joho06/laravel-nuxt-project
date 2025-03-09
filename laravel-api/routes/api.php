<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test-key', function () {
    return response()->json([
        'api_key' => env('OPENWEATHER_API_KEY'),
    ]);
});
// API Resource para manejar operaciones CRUD de usuarios
Route::apiResource('users', UserController::class)->only(['index', 'show']);

// Rutas personalizadas para obtener el clima de un usuario
Route::get('/users/{user}/weather', [UserController::class, 'getWeather']);
Route::get('/weather/{lat}/{lon}', [WeatherController::class, 'getWeather']);

