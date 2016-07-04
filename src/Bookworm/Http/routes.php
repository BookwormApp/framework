<?php

Route::get('login', 'Auth\Sessions@create');
Route::post('login', 'Auth\Sessions@store');
Route::get('logout', 'Auth\Sessions@destroy');
Route::get('password/reset/{token?}', 'Auth\Passwords@token');
Route::post('password/email', 'Auth\Passwords@send');
Route::post('password/reset', 'Auth\Passwords@update');

Route::group(['middleware' => 'auth'], function ($r) {

    $r->get('/', 'Dashboard@index');

    $r->get('settings/users', 'Users@index');
    $r->get('settings/users/create', 'Users@create');
    $r->post('settings/users/create', 'Users@store');
    $r->get('settings/users/{ref}', 'Users@edit');
    $r->post('settings/users/{ref}', 'Users@update');
    $r->delete('settings/users/{ref}', 'Users@destroy');

    $r->get('settings/projects', 'Projects@index');
    $r->get('settings/projects/create', 'Projects@create');
    $r->post('settings/projects/create', 'Projects@store');
    $r->get('settings/projects/{ref}', 'Projects@edit');
    $r->post('settings/projects/{ref}', 'Projects@update');
    $r->delete('settings/projects/{ref}', 'Projects@destroy');

    $r->get('cases', 'Cases@index');
    $r->get('cases/create', 'Cases@create');
    $r->post('cases/create', 'Cases@store');
    $r->get('cases/{ref}', 'Cases@edit');
    $r->post('cases/{ref}', 'Cases@update');
    $r->delete('cases/{ref}', 'Cases@destroy');

});
