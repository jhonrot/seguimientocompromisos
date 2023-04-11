<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cdp extends Model
{
    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'id','proyecto_id');
    }

    public function precontractuales()
    {
        return $this->hasMany(Precontractual::class, 'cdp_id', 'id');
    }
}
