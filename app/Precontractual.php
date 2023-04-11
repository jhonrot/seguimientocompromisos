<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Precontractual extends Model
{
    protected $table = "precontractuales";

    public function cdps()
    {
        return $this->hasMany(Cdp::class, 'id','cdp_id');
    }

    public function ejecuciones()
    {
        //return $this->hasMany(Ejecucion::class, 'id', 'cdp_id');
        return $this->hasMany(Ejecucion::class, 'precontractual_id', 'id');
    }
}
