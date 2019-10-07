<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Sheep;

Route::get('/', 'SheepController@index');

Route::get('/reset/', function () {
    Sheep::reset();
});

Route::get('/reproduce/', 'SheepController@breed');

Route::get('/statistics/', 'SheepController@statistics');

Route::get('/sleep/', 'SheepController@sleep');
