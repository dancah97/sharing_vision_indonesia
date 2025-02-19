<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;

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

Route::post('/article', [ArticleController::class, 'createArticle']);
Route::get('/article/{limit}/{offset}', [ArticleController::class, 'getArticles']);
Route::get('/article/{id}', [ArticleController::class, 'getArticle']);
Route::put('/article/{id}', [ArticleController::class, 'updateArticle']);
Route::delete('/article/{id}', [ArticleController::class, 'deleteArticle']);
