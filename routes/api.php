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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/logout', [AuthController::class, 'logout']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('users', [UserController::class, 'index']); // Mostrar lista de usuarios a todos los empleados
    Route::post('users', [UserController::class, 'store'])->middleware('superadmin'); // Solo los Super Admin pueden crear otros usuarios
    Route::put('users/{user}', [UserController::class, 'update']); // Modificar los usuarios usuarios
    Route::delete('users/{user}', [UserController::class, 'destroy'])->middleware('superadmin'); // Eliminar usuario
    
    Route::get('tasks', [TaskController::class, 'index']); // Mostrar lista de tareas a todos los empleados
    Route::post('tasks', [TaskController::class, 'store'])->middleware('superadmin'); // Solo los Super Admin pueden crear las tareas
    Route::put('tasks/{tasks}', [TaskController::class, 'update']); // Modificar las tareas 
    Route::delete('tasks/{tasks}', [TaskController::class, 'destroy'])->middleware('superadmin'); // Solo los Super Admin pueden eliminar las tareas
    
    Route::get('comments', [CommentController::class, 'index']); // listar los comentarios
    Route::post('comments', [CommentController::class, 'store']); // Crear comentario
    Route::put('comments/{comments}', [CommentController::class, 'update']); // Actualizar comentarios
    Route::delete('comments/{comments}', [CommentController::class, 'delete']); // eliminar comentarios
    
    Route::post('attachments', [AttachmentController::class, 'store']); // Crear Archivos
    Route::delete('attachments/{attachments}', [AttachmentController::class, 'delete']); // Eliminar Archivos
});