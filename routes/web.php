<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QueryController;
use App\Http\Controllers\CategoryController;

// ----------------------------------- домашняя страница -----------------------------------

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/home/{query_id}', [HomeController::class, 'update'])->name('home.update');

Route::redirect('/', '/home');




// ----------------------------------- пользователи -----------------------------------

Route::resource('users', UserController::class);

Route::get('/login', [UserController::class, 'loginform'])->name('loginform');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/profile', [UserController::class, 'index'])->name('profile');

// ----------------------------------- заявки -----------------------------------

Route::get('/queries', [QueryController::class, 'index'])->name('queries');

Route::get('/newquery', [QueryController::class, 'show'])->name('newquery');

Route::post('/newquery', [QueryController::class, 'store'])->name('newquery.create');

Route::get('/queries/{query_id}', [QueryController::class, 'destroy'])->name('queries.destroy');

Route::post('/queries/reject/{query_id}', [QueryController::class, 'reject'])->name('queries.reject');

Route::post('/queries/aprove/{query_id}', [QueryController::class, 'aprove'])->name('queries.aprove');

// ----------------------------------- админ -----------------------------------

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

Route::get('/home', [HomeController::class, 'index'])->name('home');
});

