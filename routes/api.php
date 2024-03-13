<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)
    ->group(function (){
        Route::get('users','getUsers');
        Route::get('users-when','getUserWithWhen');
        Route::get('users-query','getUserWithQuery');
        Route::get('users-pipline','getUserWithPipline');
    });


