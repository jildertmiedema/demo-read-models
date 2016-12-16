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
Route::get('dashboard/read', 'DashboardController@dashboardRead');
Route::get('dashboard/redis', 'DashboardController@dashboardRedis');
Route::get('dashboard/db', 'DashboardController@dashboardDb');
Route::get('search', 'SearchController@search');
Route::get('search/fulltext', 'SearchController@searchFulltext');
Route::get('sales', 'ListController@todoList');
Route::get('sales-improved', 'ListController@todoListImproved');
Route::get('sales-improved/view', 'ListController@todoListImprovedView');
Route::get('sales-improved/memory', 'ListController@todoListImprovedMemory');

Route::get('login', function () {
    \Auth::login(User::first());

    return redirect('/sales');
});

Route::get('customer/{id}', [
    'as' => 'customer.view',
    'uses' => 'HomeController@demo',
]);

Route::get('product/{id}', [
    'as' => 'product.view',
    'uses' => 'HomeController@demo',
]);

Route::get('project/{id}', [
    'as' => 'project.view',
    'uses' => 'HomeController@demo',
]);

Route::get('user/{id}', [
    'as' => 'user.view',
    'uses' => 'HomeController@demo',
]);
