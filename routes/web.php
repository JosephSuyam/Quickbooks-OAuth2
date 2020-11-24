<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('oauth/quickbooks', 'Auth\Quickbook@get_auth');
Route::get('oauth/quickbooks/callback', 'Auth\Quickbook@callback');
Route::get('quickbooks', 'Auth\Quickbook@quickbooks_access');