<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    public function organismos()
    {
        return $this->hasMany(Organismo::class, 'id','organismo_id');
    }

    public function comunas()
    {
        return $this->hasMany(Comuna::class, 'id','comuna_id');
    }

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'proyecto_id','id');
    }

    public function cdps()
    {
        return $this->hasMany(Cdp::class, 'proyecto_id','id');
    }

    public function responsables()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
}
