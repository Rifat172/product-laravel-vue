<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Inertia::render('Home', [
        'user' => Auth::check() ? Auth::user()->name : null,
    ]);
});
// Страница логина (для гостей)
Route::get('/login', function () {
    return Inertia::render('Login');
})->name('login');
Route::get('/register', function () {
    return Inertia::render('Register');
})->name('register');
// AuthController для SPA
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/api/user', [AuthController::class, 'user']);
Route::post('/register', [AuthController::class, 'register']);
