<?php

declare(strict_types=1);

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('/pets', 'PetsController@index')->name('pets');
Route::get('/about', 'AboutController@index')->name('about');
