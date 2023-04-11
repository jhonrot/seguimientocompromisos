<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Presupuesto extends Model
{
    public function modalidades():BelongsToMany
    {
        return $this->belongsToMany(Modalidad::class,'modalidad_presupuesto','presupuesto_id','modalidad_id')->withPivot('presupuesto_modalidad');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'id','proyecto_id');
    }

    public function getPresupuesto_grande_miles(){
        return "$ ".number_format($this->presupuesto_proyecto,0,",",".");
    }

    public function getPresupuesto_grande(){
        return intval($this->presupuesto_proyecto);
    }
}
