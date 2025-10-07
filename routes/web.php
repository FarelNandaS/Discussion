<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//get routes
Route::get('/', [IndexController::class, "home"])->name('home');

//route auth
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::get('/register', [IndexController::class, 'register'])->name('register');

//route index
Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/newest', [IndexController::class, 'newest'])->name('newest');

//route post
Route::get('/post/detail/{id}', [IndexController::class, 'DetailPost'])->name('detail-post');

//route profile
Route::get('/profile/{username}', [IndexController::class, 'Profile'])->name('profile');

Route::middleware('auth.alert')->group(function () {
    //route saved
    Route::get('/saved', [IndexController::class, 'saved'])->name('saved');

    //route post
    Route::get('/post/add', [IndexController::class, 'post'])->name('post-add');

    //route profile
    Route::get('/profile/edit', [IndexController::class, 'EditProfile'])->name('edit-profile');

    //route dashboard
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    //crud profile routes
    Route::post("/profile/update", [UserController::class, "update"])->name('profile-update');
    Route::post("/give-access/{id}", [UserController::class, "giveAccess"])->name('give-access');
    Route::post("/delete-access/{id}", [UserController::class, "deleteAccess"])->name('delete-access');

    //crud post routes
    Route::post("/post/save", [PostController::class, "store"])->name('post-save');
    Route::post("/post/delete", [PostController::class, "destroy"])->name('post-delete');

    //crud comment routes
    Route::post('/comment/save', [CommentController::class, 'store'])->name('comment-save');
    Route::post('/comment/delete', [CommentController::class, 'destroy'])->name('comment-delete');
});

//route auth google
Route::middleware('web')->group(function () {
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth-google');
    Route::get('/auth/google/callback', [AuthController::class, 'handlerCallback'])->name('auth-google-callback');
});

//crud login routes
Route::post("/login", [UserController::class, "index"])->name('login-attempt');
Route::post("/register", [UserController::class, "create"])->name('register-attempt');
Route::post('/logout', [UserController::class, "logout"])->name('logout-attempt');

//ajax 
Route::prefix('ajax')->group(function () {
    Route::post('follow-user', [UserController::class, 'followUser'])->name('ajax-follow-user');
    Route::post('like-post', [PostController::class, 'likePost'])->name('ajax-like-post');
    Route::post('save-post', [PostController::class, 'savePost'])->name('ajax-save-post');
});