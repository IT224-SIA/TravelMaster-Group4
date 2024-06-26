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

// Route::group([

//     'prefix' => 'api'

// ], function ($router) {
//     Route::post('login', 'AuthController@login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('user-profile', 'AuthController@me');

// });

# User Authentication skrrt skrt
$router->post('/api/login', 'AuthController@login'); // for login
$router->post('/api/logout', 'AuthController@logout'); // for logout
$router->post('/api/refresh', 'AuthController@refresh'); // for refresh and generating new token
$router->post('/api/user-profile', 'AuthController@me'); // for getting user profile

# GeoDB Cities
$router->get('/api/geodb/countries/{countryCode}', 'GeoDBController@getCountryDetails'); // for getting country details
$router->get('/api/geodb/countries/{countryCode}/regions', 'GeoDBController@getCountryRegions'); // for getting country regions
$router->get('/api/geodb/countries/{countryCode}/regions/{regionCode}', 'GeoDBController@getCountryRegionDetails'); // for getting region details
$router->get('/api/geodb/cities/{cityId}', 'GeoDBController@getCityDetails'); // for getting city details
$router->get('/api/geodb/cities/{cityId}/nearbyCities', 'GeoDBController@getCitiesNearCity'); // for getting cities near specified city
$router->get('/api/geodb/places/{placeId}', 'GeoDBController@getPlaceDetails'); // for getting place details
$router->get('/api/geodb/places/{placeId}/nearbyPlaces', 'GeoDBController@getPlacesNearPlace'); // for getting places near specified place
$router->get('/api/geodb/places/{placeId}/dateTime', 'GeoDBController@getPlaceDateTime'); // for getting place date time
$router->get('/api/geodb/places/{placeId}/time', 'GeoDBController@getPlaceTime'); // for getting place time

# WeatherAPI 
$router->get('/api/weather/forecast/{city}/{days}', 'WeatherAPIController@getWeatherForecast'); // for getting weather forecast of a city
$router->get('/api/weather/timezone/{city}', 'WeatherAPIController@getTimeZone'); // for getting time zone of a city

# COVID-19 Tracking API
$router->get('/api/covid19/{country}', 'COVID19TrackingController@getCountryData'); // for getting country data

# Task Manager
$router->get('/api/taskmanager', 'TaskManagerController@seeTasks'); // for retrieving all tasks
$router->post('/api/taskmanager', 'TaskManagerController@postTask'); // for creating a new task
$router->put('/api/taskmanager/{id}', 'TaskManagerController@editTask'); // for editing an existing task
$router->delete('/api/taskmanager/{id}', 'TaskManagerController@deleteTask'); // for deleting an existing task
