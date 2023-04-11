<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class Tema extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function estado_seguimientos()
    {
        return $this->hasMany(Estado_seguimiento::class, 'id','estado_id');
    }

    public function seguimientos()
    {
        return $this->hasMany(Seguimiento::class);
    }

    public function evidencias()
    {
        return $this->hasMany(Tema_archivo::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    
    public function sub_clasificaciones()
    {
        return $this->hasMany(Sub_clasificacion::class, 'id','subclasificacion_id');
    }
    
    public function asignador()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
    
    public function clasificaciones()
    {
        return $this->hasMany(Clasificacion::class, 'id','clasificacion_id');
    }
    
    public function equipos()
    {
        return $this->hasMany(Equipo_trabajo::class, 'id','equipo_id');
    }
    
    public function tareas_despachos()
    {
        return $this->hasMany(Tarea_despacho::class);
    }
}
