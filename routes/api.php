<?php

use App\Http\Controllers\ShortenerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/user', [UserController::class, 'user'])->middleware('auth:sanctum');

Route::post('/shorten', [ShortenerController::class, 'shorten'])->middleware('auth:sanctum');
Route::get('/links', [ShortenerController::class, 'links'])->middleware('auth:sanctum');
Route::get('/links/{shortCode}', [ShortenerController::class, 'visit']);