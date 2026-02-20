<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function(){

    // registrar persona con cuenta usuario
    Route::post("/persona/guardar-persona-user", [PersonaController::class, "funGuardarPersonaUser"]);

    // asignar cuenta a persona
    Route::post("/persona/{id}/adduser", [PersonaController::class, "funAddUserPersona"]);

    //CRUD API REST USERcsd
    Route::get("/user", [UserController::class, "funListar"]);
    Route::post("/user", [UserController::class, "funGuardar"]);
    Route::get("/user/{id}", [UserController::class, "funMostrar"]);
    Route::put("/user/{id}", [UserController::class, "funModificar"]);
    Route::delete("/user/{id}", [UserController::class, "funEliminar"]);

    // CRUD ROLES
    Route::apiResource("role", RolController::class);
    Route::apiResource("persona", PersonaController::class);
    Route::apiResource("permiso", PermisoController::class);
    Route::apiResource("documento", DocumentoController::class);

    Route::apiResource("categoria", CategoriaController::class);
    Route::apiResource("producto", ProductosController::class);
    Route::apiResource("cliente", ClienteController::class);
    Route::apiResource("pedido", PedidoController::class);


});


// Auth
Route::prefix('/v1/auth/')->group(function(){

    Route::post("/login", [AuthController::class, "funLogin"]);
    Route::post("/register", [AuthController::class, "funRegister"]);

    Route::middleware('auth:sanctum')->group(function(){
        Route::get("/profile", [AuthController::class, "funProfile"]);
        Route::post("/logout", [AuthController::class, "funLogout"]);
    });

});

// redireccion de no autenticado
Route::get("/no-autenticado", function(){
    return ["mensaje" => "No tienes permiso"];
})->name("login");
