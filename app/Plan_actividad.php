<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan_actividad extends Model
{
    protected $table = "plan_actividades";

    public function obligaciones()
    {
        return $this->hasMany(Obligacion::class, 'id','obligacion_id');
    }

    public function tareas()
    {
        return $this->hasMany(Tarea::class,'tarea_id', 'id');
    }

    public function unidades()
    {
        return $this->hasMany(Unidad::class);
    }
}
