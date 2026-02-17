<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id(); // id (BI, AI, US, PK )
            $table->string("nombres", 50);
            $table->string("apellidos", 50)->nullable();
            $table->date("fecha_nacimiento")->nullable();
            $table->boolean("estado")->default(true);
            $table->integer("ci")->nullable();
            $table->bigInteger("user_id")->unsigned()->nullable();
            $table->foreign("user_id")->references("id")->on("users");
            $table->timestamps();// created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
