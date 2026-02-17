<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $personas = DB::select("SELECT * FROM personas");
        $personas = Persona::get();
        return response()->json($personas, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validacion
        $request->validate([
            "nombres" => "required|string|min:3|max:30",
            "apellidos" => "required|string|min:5|max:50",
        ]);

        $nombres = $request->nombres;
        $apellidos = $request->apellidos;

        // DB::insert("INSERT INTO personas (nombres, apellidos) values (?,?)", [$nombres, $apellidos]);

        // $persona = DB::table("personas")->insert(["nombres"=>$nombres, "apellidos" =>$apellidos]);

        $persona = new Persona;
        $persona->nombres = $nombres;
        $persona->apellidos = $apellidos;
        $persona->save();

        return response()->json(["mensaje" => "Persona registrada"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
