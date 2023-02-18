<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/images/{filename}', [HomeController::class, 'images'])->name('images');

Route::post('/add_planets', [HomeController::class, 'AddPlanets']);
Route::post('/remove_planets', [HomeController::class, 'RemovePlanets']);

Route::post('/add_planets_moons_and_comets', [HomeController::class, 'AddPlanetsMoonsAndComets']);
Route::post('/remove_planets_moons_and_comets', [HomeController::class, 'RemovePlanetsMoonsAndComets']);