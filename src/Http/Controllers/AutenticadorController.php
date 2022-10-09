<?php

namespace Inador\Autenticador\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AutenticadorController extends Controller
{
    public function registrar(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->access_token = $user->createToken('auth_token')->plainTextToken;
        $user->token_type = 'Bearer';

        return response()->json([
            'message' => 'Bienbenido ' . $user->name,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        if(!$user = $this->autenticar($request->only('user', 'password')))
        {
            return response()->json([
                'message' => 'usuario o contraseña incorrectos'
            ], 401);
        }

        return response()->json([
            'message' => 'Bienbenido ' . $user->name,
            'user' => $user
        ]);
    }

    public function logout(Request $request) 
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Se ha cerrado la session'
        ]);
    }

    private function autenticar($credenciales)
    {
        
        if(filter_var($credenciales['user'], FILTER_VALIDATE_EMAIL))
        {
            $columna = 'email';
        }else{
            $columna = 'name';
        }
        return $this->autenticarPorColumna($columna, $credenciales);
    }

    private function autenticarPorColumna($columna, $credenciales)
    {
        if($user = User::where($columna, $credenciales['user'])->first())
        {
            if(Hash::check($credenciales['password'], $user->password))
            {
                $user->access_token = $user->createToken('auth_token')->plainTextToken;
                $user->toke_type = 'Bearer';
                return $user;
            }
        }
        return null;
    }
}