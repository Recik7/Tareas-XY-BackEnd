<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 


class TaskController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|string|in:Pending,In Progress,Blocked,Completed',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $task = Task::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Tarea creada exitosamente',
            'task' => $task
        ], 201);
    }

    public function show(Task $task)
    {
        return response()->json($task);
    }

    public function update(Request $request, Task $task)
    {
        // Verificar si el usuario autenticado es el propietario de la tarea
        if ($task->user_id !== Auth::id()) {
            return response()->json(['error' => 'No puedes actualizar esta tarea.'], 403);
        }

        $task->update($request->all());

        return response()->json($task, 200);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(null, 204);
    }
}
