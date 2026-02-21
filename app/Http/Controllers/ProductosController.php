<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // http://127.0.0.1:8000/api/producto?page=1&limit=5&q=mesa
        $limit = isset($request->limit)? $request->limit: 10;
        // $q = isset($request->q)? $request->q: "";

        if(isset($request->q)){
            $productos = Producto::orderBy('id', 'desc')
                ->where('nombre', 'like', '%'.$request->q.'%')
                ->orWhere('precio','like', '%'.$request->q.'%' )
                ->with("categoria")
                ->paginate($limit);
            return response()->json($productos, 200);
        } else{
            $productos = Producto::orderBy('id', 'desc')
                ->with("categoria")
                ->paginate($limit);
            return response()->json($productos, 200);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        // $producto->estado = $request->estado;
        $producto->save();

        return response()->json(["mensaje" => "Producto registrado"]);



    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $producto = Producto::find($id);
        if($producto){
            return response()->json($producto, 200);
        } else{
            return response()->json(["mensaje" => "Producto no encontrado"], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "nombre" => "required",
            "categoria_id" => "required"
        ]);

        $producto = Producto::findOrFail($id);
        $producto->nombre = $request->nombre;
        $producto->categoria_id = $request->categoria_id;
        $producto->precio = $request->precio;
        $producto->stock = $request->stock;
        $producto->descripcion = $request->descripcion;
        // $producto->estado = $request->estado;
        $producto->update();

        return response()->json(["mensaje" => "Producto Actualizado"]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->estado = false;
        $producto->update();
        return response()->json(["mensaje" => "Estado del Producto actualizado"]);
    }

    public function actualizarImagen(Request $request, $id){
        if($file = $request->imagen){
            $direcion_url = time().'-'.$file->getClientOriginalName();
            $file->move("imagenes", $direcion_url);

            $producto = Producto::find($id);
            $producto->imagen = "imagenes/".$direcion_url;
            $producto->update();
            return response()->json(["mensaje" => "Imagen actualizada"], 201);

        } else{
            return response()->json(["mensaje" => "La imagen es obligatoria"], 422);
        }
    }
}
