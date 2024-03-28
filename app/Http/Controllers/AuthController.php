<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    public function create(Request $request)
    {   
        $rules = [
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:Super Admin,employee', // Asegúrate de validar el rol según los valores permitidos
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        
        $user = User::create([
            'name' => $request->name, 'email' => $request->email, 'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Registro realizado con exito',
            'token' => $user->createToken('API TOKEN')->plainTextToken

        ], 200);

    }

    public function login(Request $request)
    {   
        $rules = [
            'email' => 'required|string|email|max:100',
            'password' => 'required|string'
        ];
        $validator = \Validator::make($request->input(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ],400);
        }
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => false,
                'errors' => ['Unauthorized']
            ], 401);
        }
        $user = User::where('email',$request->email)->first();
        return response()->json([
            'status' => true,
            'message' => 'Login realizado con exito',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken

        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
