<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
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



Route::post('/books/{id}/reviews', [ProductController::class, 'createBookReview']);
Route::post('/books/{id}/ratings', [ProductController::class, 'createBookRating']);

Route::get('/books/{id}/reviews', [ProductController::class, 'getBookReviews']);
Route::get('/books/{id}/ratings', [ProductController::class, 'getBookRatings']);


//Add items to the cart
Route::post('/cart/add/{id}', [CartController::class, 'addToCart']);

Route::get('/cart', [CartController::class, 'index']);
Route::patch('/cart/update/{id}', [CartController::class, 'updateCart']);
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart']);
Route::get('/cart/checkout', [CartController::class, 'checkout']);
