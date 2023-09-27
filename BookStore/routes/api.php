<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProductController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User Registration and login
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

//View books
Route::get('/books', [BookController::class, 'index']);

//View books by id 
Route::get('/books/{id}', [ProductController::class, 'getBookDetails']);



Route::post('/api/books/{id}/reviews', [ProductController::class, 'createBookReview']);
Route::post('/api/books/{id}/ratings', [ProductController::class, 'createBookRating']);

Route::get('/api/books/{id}/reviews', [ProductController::class, 'getBookReviews']);
Route::get('/api/books/{id}/ratings', [ProductController::class, 'getBookRatings']);

