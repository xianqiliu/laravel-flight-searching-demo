<?php

use App\Http\Controllers\Api\DestinationsController;
use App\Http\Controllers\Api\FlightOffersController;
use App\Http\Controllers\Api\LocationsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('direct-destinations', [DestinationsController::class, 'getDirectDestinations']);
Route::get('flight-offers', [FlightOffersController::class, 'getFlightOffers']);
Route::get('locations', [LocationsController::class, 'getLocations']);
