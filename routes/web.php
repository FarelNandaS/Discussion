<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReactionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// if (!app()->)
//get routes
Route::get('/', [IndexController::class, "home"])->name('home');
Route::get("/test", function () {
    return 'test';
});

//route auth
Route::get('/login', [IndexController::class, 'login'])->name('login');
Route::get('/register', [IndexController::class, 'register'])->name('register');

//route index
Route::get('/search', [IndexController::class, 'search'])->name('search');
Route::get('/newest', [IndexController::class, 'newest'])->name('newest');

//route post
Route::get('/post/detail/{id}', [IndexController::class, 'DetailPost'])->name('detail-post');

//route profile
Route::get('/user/profile/{username}', [IndexController::class, 'Profile'])->name('profile');

Route::middleware('auth.alert')->group(function () {
    //route saved
    Route::get('/saved', [IndexController::class, 'saved'])->name('saved');

    //route post
    Route::get('/post/add', [IndexController::class, 'post'])->name('post-add');
    Route::get('/post/edit/{id}', [IndexController::class, 'postEdit'])->name('post-edit');

    //route profile
    Route::get('/user/edit', [IndexController::class, 'EditProfile'])->name('edit-profile');

    //route dashboard
    Route::get('/dashboard', [IndexController::class, 'dashboard'])->name('dashboard');

    //crud profile routes
    Route::post("/profile/update", [UserController::class, "update"])->name('profile-update');
    Route::post("/give-access/{id}", [UserController::class, "giveAccess"])->name('give-access');
    Route::post("/delete-access/{id}", [UserController::class, "deleteAccess"])->name('delete-access');

    //crud post routes
    Route::post("/post/save", [PostController::class, "store"])->name('post-save');
    Route::post("/post/update", [PostController::class, "update"])->name('post-update');
    Route::post("/post/delete", [PostController::class, "destroy"])->name('post-delete');

    //crud comment routes
    Route::post('/comment/save', [CommentController::class, 'store'])->name('comment-save');
    Route::post('/comment/delete', [CommentController::class, 'destroy'])->name('comment-delete');

    //route settings
    Route::get('/settings', [IndexController::class, 'settings'])->name('settings');
    Route::post('/settings/changePassword', [SettingController::class, 'changePassword'])->name('settings-change-password');
});

Route::prefix('admin')->middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin-dashboard');

    Route::get('/report', [AdminController::class, 'reports'])->name('admin-reports');
    Route::get('/report/{type}/{id}', [AdminController::class, 'reportDetail'])->name('admin-reports-detail');

    Route::get('/appeals', [AdminController::class, 'appeals'])->name('admin-appeals');

    Route::get('/user/profile/{username}', [IndexController::class, 'Profile'])->name('admin-profile');
    Route::get('/user/edit', [IndexController::class, 'EditProfile'])->name('admin-edit-profile');

    Route::post('/report/action/suspend', [ReportController::class, 'actionSuspend'])->name('admin-report-action-suspend');
    Route::post('/report/action/dismiss', [ReportController::class, 'actionDismiss'])->name('admin-report-action-dismiss');
});

Route::middleware('web')->group(function () {
    //route auth google
    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth-google');
    Route::get('/auth/google/callback', [AuthController::class, 'handlerGoogleCallback'])->name('auth-google-callback');
});

//crud login routes
Route::post("/login", [UserController::class, "index"])->name('login-attempt');
Route::post("/register", [UserController::class, "create"])->name('register-attempt');
Route::post('/logout', [UserController::class, "logout"])->name('logout-attempt');

//ajax 
Route::prefix('ajax')->group(function () {
    Route::post('send-report', [ReportController::class, 'sendReport'])->name('ajax-send-report');
    Route::post('check-password', [SettingController::class, 'checkPassword'])->name('ajax-check-password');
    Route::post('save-post', [PostController::class, 'savePost'])->name('ajax-save-post');
    Route::post('react-post', [ReactionController::class, 'post'])->name('ajax-react-post');
});