<?php

// Socialite Auth
Route::get('/login/callback', 'Auth\LoginController@handleProviderCallback')->name('login.callback');
Route::get('/login', 'Auth\LoginController@redirectToProvider')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', 'PeopleController@index')->name('people.index');
});

