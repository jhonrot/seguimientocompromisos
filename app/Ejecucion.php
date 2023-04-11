<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ejecucion extends Model
{
    protected $table = "ejecuciones";

    public function precontractuales()
    {
        return $this->hasMany(Precontractual::class, 'id','precontractual_id');
    }
}
