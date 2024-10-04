<?php

use App\Core\Route;

Route::get('/', 'HomeController@index');

Route::get('/api/v1/products', 'ProductController@index');
Route::get('/api/v1/products/search', 'ProductController@search');
Route::get('/api/v1/products/paginate', 'ProductController@paginate');
Route::get('/api/v1/products/{id}', 'ProductController@show');
Route::post('/api/v1/products', 'ProductController@store');
Route::put('/api/v1/products/{id}', 'ProductController@update');
Route::delete('/api/v1/products/{id}', 'ProductController@remove');
