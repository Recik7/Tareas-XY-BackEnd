<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        // Validar datos del formulario $request->validate([...]);

        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    public function update(Request $request, Comment $comment)
    {
        // Validar datos del formulario $request->validate([...]);

        $comment->update($request->all());

        return response()->json($comment, 200);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
