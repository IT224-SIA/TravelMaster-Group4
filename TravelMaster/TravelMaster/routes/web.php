<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// $router->get('/', function () use ($router) {
//     echo "<center> Welcome </center>";
// });

// $router->get('/version', function () use ($router) {
//     return $router->app->version();
// });

// Route::group([

//     'prefix' => 'api'

// ], function ($router) {
//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('user-profile', 'AuthController@me');

// });
# User Authentication skrrt skrt
$router->post('/api/login', 'AuthController@login');
$router->post('/api/logout', 'AuthController@logout');
$router->post('/api/refresh', 'AuthController@refresh');
$router->post('/api/user-profile', 'AuthController@me');

# GeoDB Cities
$router->get('/api/geodb/countries/{countryCode}', 'GeoDBController@getCountryDetails');
$router->get('/api/geodb/countries/{countryCode}/regions', 'GeoDBController@getCountryRegions');
$router->get('/api/geodb/countries/{countryCode}/regions/{regionCode}', 'GeoDBController@getCountryRegionDetails');
$router->get('/api/geodb/cities/{cityId}', 'GeoDBController@getCityDetails');
$router->get('/api/geodb/cities/{cityId}/nearbyCities', 'GeoDBController@getCitiesNearCity');
$router->get('/api/geodb/cities/{fromCityId}/distance/{toCityId}', 'GeoDBController@getCityDistance'); // unya nani
$router->get('/api/geodb/cities/{cityId}/time', 'GeoDBController@getCityTime');
$router->get('/api/geodb/places/{placeId}', 'GeoDBController@getPlaceDetails');
$router->get('/api/geodb/places/{placeId}/nearbyPlaces', 'GeoDBController@getPlacesNearPlace');
$router->get('/api/geodb/places/{placeId}/distance', 'GeoDBController@getPlaceDistance'); // unya nani
$router->get('/api/geodb/places/{placeId}/dateTime', 'GeoDBController@getPlaceDateTime');
$router->get('/api/geodb/places/{placeId}/time', 'GeoDBController@getPlaceTime');

# WeatherAPI
$router->get('/api/weather/forecast/{city}/{days}', 'WeatherAPIController@getWeatherForecast');
$router->get('/api/weather/timezone/{city}', 'WeatherAPIController@getTimeZone');

# COVID-19 Tracking API
$router->get('/api/covid19/{country}', 'COVID19TrackingController@getCountryData');

# Task Manager
$router->get('/api/taskmanager', 'TaskManagerController@seeTasks');
$router->post('/api/taskmanager', 'TaskManagerController@postTask');
$router->put('/api/taskmanager/{id}', 'TaskManagerController@editTask'); 
$router->delete('/api/taskmanager/{id}', 'TaskManagerController@deleteTask'); 
