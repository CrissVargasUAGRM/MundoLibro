<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'AuthController@login');
Route::post('passwordRecovery', 'AuthController@requestPasswordRecovery');
Route::post('password-recovery','AuthController@passwordRecovery');