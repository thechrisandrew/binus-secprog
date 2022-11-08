<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile');
Route::post('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile');
Route::post('/profile/changepw', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.changepw');
Route::post('/profile/changeavatar', [App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.changeavatar');

Route::post('/upload', [App\Http\Controllers\UploadController::class, 'store'])->name('upload');

Auth::routes();

// Route::get('/post', [PostController::class, 'index'])->name('post');
Route::post('/add-post', [PostController::class, 'store'])->name('posting');
