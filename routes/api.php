<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController; 
use App\Http\Controllers\CommentController; 
use App\Http\Controllers\AttachmentController; 
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


Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'create']);
#Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::post('logout', 'App\Http\Controllers\AuthController@logout')->middleware('auth:api');
#Route::resource('users', UserController::class);





Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('users', [UserController::class, 'index']); // Mostrar lista de usuarios
    Route::post('users', [UserController::class, 'store'])->middleware('superadmin'); 
    Route::put('users/{user}', [UserController::class, 'update'])->middleware('superadmin'); 
    Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('superadmin'); // Eliminar usuario
    Route::get('tasks', [TaskController::class, 'index']); // Mostrar lista de usuarios
    Route::post('tasks', [TaskController::class, 'store'])->middleware('superadmin');
    Route::put('tasks/{tasks}', [TaskController::class, 'update'])->middleware('superadmin');
    Route::delete('tasks/{tasks}', [TaskController::class, 'destroy'])->middleware('superadmin'); // Eliminar usuario
    Route::get('comments', [CommentController::class, 'index']); // Mostrar lista de usuarios
    Route::post('comments', [CommentController::class, 'store']); // Mostrar lista de usuarios
    Route::put('comments/{comments}', [CommentController::class, 'update']); // Mostrar lista de usuarios
    Route::delete('comments/{comments}', [CommentController::class, 'delete']); // Mostrar lista de usuarios
    Route::get('attachments', [AttachmentController::class, 'index']); // Mostrar lista de usuarios
    // Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('superadmin'); // Eliminar usuario
});

// Route::middleware(['auth:sanctum', 'superadmin'])->group(function () {
//     Route::resource('users', UserController::class);
//     Route::resource('tasks', TaskController::class);
//     Route::resource('comments', CommentController::class);
//     Route::resource('attachments', AttachmentController::class);
// });
