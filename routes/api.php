<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return response()->json(['message' => 'Api fonctionnelle']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/users', UserController::class);

    Route::apiResource('/games', GameController::class);

    Route::apiResource('comments', CommentController::class);
    Route::get('game/comments/{game}', [CommentController::class, 'getCommentsByGameId']);

    Route::apiResource('category', CategoryController::class);

    Route::get('get_games/{id}', [GameController::class, 'getGameFile']);

    Route::get('/categories/{game}/games', [GameController::class, 'indexByCategory']);

    Route::get('/me', [AuthController::class, 'me']);

});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);



