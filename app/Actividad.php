<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = "actividades";

    public function estado_seguimientos()
    {
        return $this->hasMany(Estado_seguimiento::class, 'id','estado_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class, 'id','seguimiento_id');
    }

    public function evidencias()
    {
        return $this->hasMany(Actividad_archivo::class);
    }
}
