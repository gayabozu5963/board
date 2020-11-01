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

Auth::routes();

Route::get('/', 'PostController@index')->name('posts.index');

Route::get('/posts/search', 'PostController@search')->name('posts.search');

Route::resource('/posts', 'PostController', ['except' => ['index']]);

Route::resource('/users', 'UserController');

Route::get('/user', 'UserController@index')->name('user.index')->middleware('auth');

Route::get('/user/userEdit', 'UserController@userEdit')->name('user.userEdit')->middleware('auth');

Route::post('/user/userEdit', 'UserController@userUpdate')->name('user.userUpdate')->middleware('auth');

Route::resource('/comments', 'CommentController', )->middleware('auth');

Route::resource('/replies', 'ReplieController')->middleware('auth');

// Route::resource('/posts/{id}', 'PostController@rep')->name('posts.rep');


