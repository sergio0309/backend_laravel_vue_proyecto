<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // http://127.0.0.1:8000/api/producto?page=1&limit=5&q=mesa
        $limit = isset($request->limit)? $request->limit: 10;
        // $q = isset($request->q)? $request->q: "";

        if(isset($request->q)){
            $pedidos = Pedido::orderBy('id', 'desc')
                ->where('fecha', 'like', '%'.$request->q.'%')
                ->orWhere('estado','like', '%'.$request->q.'%' )
                ->with("cliente", "productos")
                ->paginate($limit);
            return response()->json($pedidos, 200);
        } else{
            $pedidos = Pedido::orderBy('id', 'desc')
                ->with("cliente", "productos")
                ->paginate($limit);
            return response()->json($pedidos, 200);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        {
            "cliente_id": 4,
            "productos": [
                { "id": 3,"cantidad": 1 },
                { "id": 5,"cantidad": 2 },
                { "id": 2,"cantidad": 3 },
            ]
        }
        */

        $request->validate([
            "cliente_id" => "required",
            "productos" => "required|array|min:1"
        ]);

        $cliente = Cliente::find($request->cliente_id);

        $pedido = new Pedido();
        $pedido->fecha = date("Y-m-d H:i:s");
        $pedido->observaciones = $request->observacion;
        $pedido->descripcion = $request->descripcion;
        $pedido->cliente_id = $request->cliente_id;
        $pedido->user_id = Auth::id();
        $pedido->save();

        // M:N
        foreach ($request->productos as $prod) {

            $prod_id = $prod["id"];
            $cant = $prod["cantidad"];

            $pedido->productos()->attach($prod_id, ["cantidad" => $cant]);
        }

        $pedido->estado = 2;
        $pedido->update();

        return response()->json(["mensaje" => "Pedido registado"]);

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
