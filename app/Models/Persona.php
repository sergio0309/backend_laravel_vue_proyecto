<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    // protected $table = "personas";

    // protected $primaryKey = 'idper';
    // public $incrementing = false;
    // protected $keyType = 'string';
    // public $timestamps = false;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documentos(){
        return $this->hasMany(Documento::class);
    }
}
