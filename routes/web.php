<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//get routes
Route::get('/', [IndexController::class, "home"]);
Route::get('/login', [IndexController::class, 'login']);
Route::get('/register', [IndexController::class, 'register']);
Route::get('/search', [IndexController::class, 'search']);
Route::get('/newest', [IndexController::class, 'newest']);
Route::get('/saved', [IndexController::class, 'saved']);
Route::get('/post', [IndexController::class, 'post']);
Route::get('/post/detail/{id}', [IndexController::class, 'DetailPost']);
Route::get('/profile/edit', [IndexController::class,'EditProfile']);
Route::get('/{username}', [IndexController::class, 'Profile']);

//crud login routes
Route::post("/login/form", [UserController::class, "index"]);
Route::post("/register/form", [UserController::class, "create"]);
Route::post('/logout', [UserController::class, "logout"]);

//crud profile routes
Route::post("/profile/update", [UserController::class,"update"]);
Route::post("/give-access/{id}", [UserController::class,"giveAccess"]);
Route::post("/delete-access/{id}", [UserController::class,"deleteAccess"]);

//crud post routes
Route::post("/post/add", [PostController::class, "store"]);
Route::post("/post/delete/{id}", [PostController::class, "destroy"]);

//crud comment routes
Route::post('/comment/add/{id}', [CommentController::class, 'store']);
Route::post('/comment/delete/{id}', [CommentController::class, 'destroy']);
