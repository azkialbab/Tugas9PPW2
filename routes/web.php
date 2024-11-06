<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Middleware\Admin;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/buku/create', [BooksController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BooksController::class, 'store'])->name('buku.store');
    Route::delete('/buku/{id}', [BooksController::class, 'destroy'])->name('buku.destroy');
    Route::get('/buku/{id}/edit', [BooksController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [BooksController::class, 'update'])->name('buku.update');
});



Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/buku', [BooksController::class, 'index'])->name('buku.index');
    Route::get('/buku/search', [BooksController::class, 'search'])->name('buku.search'); 
});


Route::controller(LoginRegisterController::class)->group(function() {
    Route::get('/register', 'register')->name('register');
    Route::post('/store', 'store')->name('store');
    Route::get('/login', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
    

    Route::get('/dashboard', 'dashboard')->name('dashboard')->middleware('auth');
    Route::post('/logout', 'logout')->name('logout');
});
