<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('/users', [UserController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/books', [BookController::class, 'store']);
    
    Route::post('/books/list', [BookController::class, 'storeBookList']);

    Route::get('/books', [BookController::class, 'index']);

    Route::delete('/books/{book}', [BookController::class, 'destroy']);

    Route::post('/books/{book}/favorite', [BookController::class, 'addFavorite']);
    
    Route::get('/books/favorites', [BookController::class, 'favoriteBooks']);
}); 