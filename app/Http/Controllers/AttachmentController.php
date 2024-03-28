<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        // Validar datos del formulario $request->validate([...]);

        $attachment = Attachment::create($request->all());

        return response()->json($attachment, 201);
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete();

        return response()->json(null, 204);
    }
}
