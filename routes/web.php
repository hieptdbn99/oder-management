<?php

use App\Http\Controllers\OrderController;
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
Route::resource('order', 'OrderController');
Route::post('order/addproduct', 'OrderController@addProduct')->name('addProduct');
Route::delete('order/removeproduct/{order_id}/{product_id}', 'OrderController@removeProduct')->name('removeProduct');
Route::get('order/editproduct/{order_id}/{product_id}', 'OrderController@editProduct')->name('editProduct');
Route::put('order/updateproduct/{order_id}/{product_id}', 'OrderController@updateProduct')->name('updateProduct');


Route::get('/home', 'HomeController@index')->name('home');
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');