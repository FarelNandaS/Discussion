<?php

use App\Http\Controllers\IndexController;
use Illuminate\Support\Facades\Route;

Route::get('/', [IndexController::class, "home"]);
Route::get('/login', [IndexController::class, 'login']);
