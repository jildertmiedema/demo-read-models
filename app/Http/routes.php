<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use App\User;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', 'DashboardController@dashboard');
Route::get('search', 'SearchController@search');
Route::get('sales', 'ListController@todoList');
Route::get('login', function () {
    \Auth::login(User::first());

    return redirect('/sales');
});

Route::get('customer/{id}', [
    'as' => 'customer.view',
    'uses' => 'DashboardController@dashboard',
]);
