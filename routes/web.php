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
Auth::routes(['register' => false, 'login' => false]);

Route::get('/register', array('as' => 'register', 'uses' => 'API\AuthController@register'))->middleware('guest');
Route::post('/register', array('as' => 'register', 'uses' => 'API\AuthController@register'))->middleware('guest');;

Route::get('/', array('as' => 'home', 'uses' => 'HomeController@home'));

Route::group(['middleware' => 'user'], function () {
    
     //list of all packages
     Route::get('/user-all-packages', array('as' => 'all-packages', 'uses' => 'UsersController@allPackages'));
     //add a package
    Route::get('user-add-package', array('as' => 'user-add-package', 'uses' => 'UsersController@addPackage'));
    Route::post('user-add-package', array('as' => 'user-add-package', 'uses' => 'UsersController@addPackage'));
});

Route::group(['middleware' => 'admin'], function () {
    //list user with the role of user
    Route::get('/users', array('as' => 'users', 'uses' => 'AdminController@users'));
    //make a user a deliverer
    Route::post('/make-deliverer', array('as' => 'make-deliverer', 'uses' => 'AdminController@makeDeliverer'));
    //list deliverers
    Route::get('/deliverers', array('as' => 'deliverers', 'uses' => 'AdminController@deliverersList'));
    //make a deliverer a user
    Route::post('/remove-deliverer', array('as' => 'remove-deliverer', 'uses' => 'AdminController@removeDeliverer'));
    //list one package
    Route::post('/package', array('as' => 'package', 'uses' => 'AdminController@package'));
    //list undelivered packages
    Route::get('/packages', array('as' => 'packages', 'uses' => 'AdminController@packages'));
    //list of all packages
    Route::get('/all-packages', array('as' => 'all-packages', 'uses' => 'AdminController@allPackages'));
    //mark package as delivered
    Route::post('/mark-delivered/{package}', array('as' => 'delivered', 'uses' => 'AdminController@delivered'));
    //add a package
    Route::get('add-package', array('as' => 'add-package', 'uses' => 'AdminController@addPackage'));
    Route::post('add-package', array('as' => 'add-package', 'uses' => 'AdminController@addPackage'));
    //edit a package
    Route::get('edit-package/{package}', array('as' => 'edit-package', 'uses' => 'AdminController@editPackage'));
    Route::post('edit-package/{package}', array('as' => 'edit-package', 'uses' => 'AdminController@editPackage'));
    //delete a package
    Route::post('delete-package/{package}', array('as' => 'delete-package', 'uses' => 'AdminController@deletePackage'));
    //show all the current deliveries
    Route::get('current-deliveries', array('as' => 'current-deliveries', 'uses' => 'AdminController@currentDeliveries'));
    Route::post('current-deliveries', array('as' => 'current-deliveries', 'uses' => 'AdminController@currentDeliveries'));
    //return the deliverers
    //Route::post('/deliverers-on-deliverin', array('as' => 'deliverers-on-deliverin', 'uses' => 'AdminController@deliverersOnDelivering'));
});

Route::group(['middleware' => 'deliverer', 'prefix' => 'deliverer'], function () {
    //home
    Route::get('/packages-map', array('as' => 'packages-map', 'uses' => 'DelivererController@packagesMap'));//->middleware('seekdelivery');
    //get undelivered packages
    Route::post('/undelivered-packages', array('as' => 'undelivered-packages', 'uses' => 'DelivererController@undeliveredPackages'));
    //deliver a package
    Route::post('/deliver-package', array('as' => 'deliver-package', 'uses' => 'DelivererController@deliverPackage'));
    //package info
    Route::get('/package-info', array('as' => 'package-info', 'uses' => 'DelivererController@packageInfo'))->middleware('hasdelivery');
    Route::post('/package-info', array('as' => 'package-info', 'uses' => 'DelivererController@packageInfo'));
    //mark package as delivered
    Route::post('/mark-delivered', array('as' => 'd-delivered', 'uses' => 'DelivererController@delivered'));
    //packages taken by the deliverer
    Route::post('/deliverer-assigned-packages', array('as' => 'deliverer-assigned-packages', 'uses' => 'DelivererController@delivererAssignedPackages'));
});
