<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tarea_despacho extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function tareas()
    {
        return $this->hasMany(Tema_despacho::class, 'id','tema_despacho_id');
    }

    public function temas()
    {
        return $this->hasMany(Tema::class, 'id','tema_id');
    }
    
    public function creador()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
}
