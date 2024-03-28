<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        // Definir reglas de validación
        $rules = [
            'user_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:tasks,id',
            'file_path' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ];

        // Crear un validador con las reglas definidas y los datos de la solicitud
        $validator = \Validator::make($request->all(), $rules);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        // Crear el archivo adjunto si la validación pasa
        $attachment = Attachment::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Archivo adjunto creado exitosamente',
            'attachment' => $attachment
        ], 201);
    }

    public function destroy(Attachment $attachment)
    {
        $attachment->delete();

        return response()->json(null, 204);
    }
}
