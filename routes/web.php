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

/* Route::get('/', function () {
    return view('welcome');
}); */
Route::group(['middleware' => 'auth'], function() {
    Route::get('/admin/posts', 'Admin\PostsController@index');
    Route::get('/admin/posts/create', 'Admin\PostsController@create');
    Route::post('/admin/posts/store/{isPublished?}', 'Admin\PostsController@store');
    Route::get('/admin/posts/{post}/edit', 'Admin\PostsController@edit');
    Route::put('/admin/posts/{post}/update/{isPublished?}', 'Admin\PostsController@update');
    Route::delete('/admin/posts/{post}', 'Admin\PostsController@delete');
});

Route::group([], function() {
    Route::get('/', 'HomeController@index');
    Route::get('/view/{post}', 'HomeController@view');
});

Auth::routes();
