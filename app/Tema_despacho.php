<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Tema_despacho extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    
    public function evidencias()
    {
        return $this->hasMany(Tema_despacho_archivo::class);
    }
    
    public function seguimientos()
    {
        return $this->hasMany(Tarea_despacho::class);
    }
    
    public function creador()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
}
