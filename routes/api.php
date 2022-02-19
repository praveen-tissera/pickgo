<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//auth routes
//login
Route::post('login', 'API\AuthController@login');
Route::post('register', 'API\AuthController@register');

Route::group(['middleware' => 'auth:api'], function(){
    //list users with the role of user
    Route::post('users', 'AdminController@users');
    //make a user a deliverer
    Route::post('/make-deliverer', 'AdminController@makeDeliverer');
    //list one package
    Route::post('/package', 'AdminController@package');
    //list undelivered packages
    Route::get('/packages', 'AdminController@packages');
    //mark package as delivered
    Route::post('/mark-delivered/{package}', 'AdminController@delivered');
    //add a package
    Route::post('add-package', 'AdminController@addPackage');
    //edit package
    Route::post('edit-package/{package}', 'AdminController@editPackage');
    //delete a package
    Route::post('delete-package/{package}', 'AdminController@deletePackage');
    //list user with the role of deliverer
    Route::get('/deliverers', 'AdminController@deliverers');
    //assign package to deliverer
    Route::post('/assign-package', 'AdminController@assignPackage');
});