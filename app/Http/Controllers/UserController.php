<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function funListar(){

        // SQL
        // $usuarios = DB::select("select * from users");
        // Query Builder
        // $usuarios = DB::table("users")->select("name")->get();
        // Eloquent ORM
        $usuarios = User::get();
        return $usuarios;

    }

    public function funGuardar(Request $request){

        $nombre = $request->name;
        $correo = $request->email;
        $password = $request->password;

        $usuario = new User();
        $usuario->name = $nombre;
        $usuario->email = $correo;
        $usuario->password = $password;
        $usuario->save();
        return ["mensaje" => "usuario registrado en la BD"];


    }

    public function funMostrar($id){

        $usuario = User::findORFail($id);
        return response()->json($usuario,200);

    }

    public function funModificar(Request $request, $id){

        $nombre = $request->name;
        $correo = $request->email;
        $password = $request->password;

        $usuario = User::findORFail($id);
        $usuario->name = $nombre;
        $usuario->email = $correo;
        $usuario->password = $password;
        $usuario->update();
        return response()->json(
            ["mensaje" => "Usuario actualizado"],201
        );


    }


    public function funEliminar($id){

        $usuario = User::findORFail($id);
        $usuario->delete();
        return response()->json(
            ["mensaje" => "Usuario eliminado"],200
        );

    }


}
