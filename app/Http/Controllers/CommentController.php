<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'comment' => 'required|string|max:255',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $comment = Comment::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comentario creado exitosamente',
            'comment' => $comment
        ], 201);
    }

    public function update(Request $request, Comment $comment)
    {

        $comment->update($request->all());

        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
