<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::get();
        return response()->json($clientes, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre_completo" => "required"
        ]);

        $cliente = new Cliente();
        $cliente->nombre_completo = $request->nombre_completo;
        $cliente->ci_nit = $request->ci_nit;
        $cliente->telefono = $request->telefono;
        $cliente->direccion = $request->direccion;
        $cliente->correo = $request->correo;
        $cliente->save();

        return response()->json(["mensaje" => "Cliente Registrado", "cliente" => $cliente], 201);
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
