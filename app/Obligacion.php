<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obligacion extends Model
{
    protected $table = "obligaciones";

    public function objetivos()
    {
        return $this->hasMany(Objetivo::class, 'id','objetivo_id');
    }
}
