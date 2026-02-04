<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function funLogin(Request $request){
        // validar datos
        $credenciales = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        // autenticar si el correo y contraseña son correctas
        if(!Auth::attempt($credenciales)){
            return response()->json(["mesaje" => "Credenciales Incorrectas"], 401);
        }

        //generar token
        $token = $request->user()->createToken("Token Auth ")->plainTextToken;
        //responder
        return response()->json(["access_token" => $token, "user" => $request->user()], 201);
    }

    public function funRegister(Request $request){

    }

    public function funProfile(Request $request){
        $usuario = $request->user();
        return response()->json($usuario, 200);
    }

    public function funLogout(Request $request){
        $usuario = $request->user();
        $usuario->tokens()->delete();
        return response()->json(["mensaje" => "Salio"],200);
    }
}
