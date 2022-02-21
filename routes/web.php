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

Auth::routes();

Route::get('/', 'HomeController@home')->name('home');
Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::get('/getFee', 'ProfileController@getFee');
Route::get('/galleryImages', 'CoachingProfileController@galleryImages');
Route::get('/pricing', 'PricingController@index');
Route::get('/deleteRecord/{id}', 'PricingController@delete');
Route::get('/page/{id}', 'PageController@index');
Route::get('/students', 'StudentsController@index');

Route::post('/updateProfile', 'ProfileController@updateProfile');
Route::post('/updatecProfile', 'CoachingProfileController@updateProfile');
Route::post('/addFee', 'ProfileController@addFee');
Route::post('/delFee', 'ProfileController@delFee');
Route::post('/addGalleryImage', 'CoachingProfileController@addGalleryImage');
Route::post('/deleteImage', 'CoachingProfileController@deleteImage');
Route::post('/addRecord', 'PricingController@addRecord');
Route::post('/follow', 'HomeController@follow');
Route::post('/unfollow', 'HomeController@unfollow');
Route::post('/button', 'HomeController@button');
Route::post('/annoucement', 'HomeController@annoucement');


