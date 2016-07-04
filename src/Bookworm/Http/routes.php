<?php

Route::get('login', 'Auth\Sessions@create');
Route::post('login', 'Auth\Sessions@store');
Route::get('logout', 'Auth\Sessions@destroy');
Route::get('password/reset/{token?}', 'Auth\Passwords@token');
Route::post('password/email', 'Auth\Passwords@send');
Route::post('password/reset', 'Auth\Passwords@update');

Route::group(['middleware' => 'auth'], function($r) {

    $r->get('/', 'Dashboard@index');

});