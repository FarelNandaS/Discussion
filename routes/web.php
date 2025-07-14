<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SavedController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/post', [IndexController::class, 'post']);
    Route::get('/profile/edit', [IndexController::class, 'EditProfile']);

    //crud profile routes
    Route::post("/profile/update", [UserController::class, "update"]);
    Route::post("/give-access/{id}", [UserController::class, "giveAccess"]);
    Route::post("/delete-access/{id}", [UserController::class, "deleteAccess"]);

    //crud post routes
    Route::post("/post/add", [PostController::class, "store"]);
    Route::post("/post/delete/{id}", [PostController::class, "destroy"]);
    Route::post("/postDetail/delete/{id}", [PostController::class, "destroyDetailPost"]);
    Route::get('/saved', [IndexController::class, 'saved']);

    //crud comment routes
    Route::post('/comment/add/{id}', [CommentController::class, 'store']);
    Route::post('/comment/delete/{id}', [CommentController::class, 'destroy']);

    //crud like routes
    Route::post('/post/{id}/like', [LikeController::class, 'toggleLike']);

    //crud save routes
    Route::post('/post/{id}/save', [SavedController::class, 'toggleSave']);

    //crud follow routes
    Route::post('/follow/{id}', [FollowerController::class, 'toggleFollow']);
});

//get routes
Route::get('/', [IndexController::class, "home"]);
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::get('/register', [IndexController::class, 'register']);
Route::get('/search', [IndexController::class, 'search']);
Route::get('/newest', [IndexController::class, 'newest']);
Route::get('/post/detail/{id}', [IndexController::class, 'DetailPost']);
Route::get('/{username}', [IndexController::class, 'Profile']);

//crud login routes
Route::post("/login/form", [UserController::class, "index"]);
Route::post("/register/form", [UserController::class, "create"]);
Route::post('/logout', [UserController::class, "logout"]);
