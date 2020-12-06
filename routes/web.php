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

Route::post('/', 'PostController@store')->name('posts.store');

Route::get('/posts/search', 'PostController@search')->name('posts.search');

Route::get('/posts/show_pic/{image}', 'PostController@show_pic')->name('posts.show_pic');

Route::resource('/posts', 'PostController', ['except' => ['index']]);

Route::resource('/users', 'UserController')->middleware('auth');

Route::get('/user', 'UserController@index')->name('user.index')->middleware('auth');

Route::get('/user/userEdit', 'UserController@userEdit')->name('user.userEdit')->middleware('auth');

Route::post('/user/userEdit', 'UserController@userUpdate')->name('user.userUpdate')->middleware('auth');


Route::get('/user/follow_show', 'UserController@follow_show')->name('user.follow_show')->middleware('auth');

Route::get('/user/follower_show', 'UserController@follower_show')->name('user.follower_show')->middleware('auth');


Route::resource('/comments', 'CommentController', )->middleware('auth');

Route::resource('/replies', 'ReplieController')->middleware('auth');

Route::get('/replie/like/{id}', 'ReplieController@like')->name('replie.like')->middleware('auth');

Route::get('/replie/unlike/{id}', 'ReplieController@unlike')->name('replie.unlike')->middleware('auth');

Route::get('/comment/like/{id}', 'CommentController@like')->name('comment.like')->middleware('auth');

Route::get('/comment/unlike/{id}', 'CommentController@unlike')->name('comment.unlike')->middleware('auth');


Route::get('/post/fav/{id}', 'PostController@fav')->name('post.fav')->middleware('auth');
Route::get('/post/unfav/{id}', 'PostController@unfav')->name('post.unfav')->middleware('auth');

// フォロー/フォロー解除を追加
Route::post('users/{user}/follow', 'UserController@follow')->name('follow')->middleware('auth');
Route::delete('users/{user}/unfollow', 'UserController@unfollow')->name('unfollow')->middleware('auth');


Route::get('/repliereplie/like/{id}', 'RepliereplieController@like')->name('repliereplie.like')->middleware('auth');

Route::get('/repliereplie/unlike/{id}', 'RepliereplieController@unlike')->name('repliereplie.unlike')->middleware('auth');






