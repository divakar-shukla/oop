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

Route::get("/post", function (){
    return view('post');
});
Route::get("/post/{id?}", function ($id = null){
    return "<h1>My role number is {$id}.";
})->whereNumber('id');

// Route::view("post", "/user");
Route::prefix('exit')->group(function(){
    Route::get('/page', function(){
        return "<h2>divakars</h2>";
    });
});

Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        // Matches The "/admin/users" URL
        return "<h2>divakars</h2>";
    });
    Route::get('/page', function(){
        return "<h2> page </h2>";
    });
});

Route::redirect('/ana', "/post");

Route::fallback(function(){
     return "<h3>This page is not Exist. Please back to Home</h3>";
});