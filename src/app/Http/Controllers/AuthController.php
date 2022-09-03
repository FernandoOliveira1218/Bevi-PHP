<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->all(['email', 'password']); //[]

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Usuario ou senha invalido!'], 401);
        }

        $user = User::where(['email' => $request->email])->firstOrFail();

        return response()->json(['user' => $user, 'token' => $token]);
    }
}
