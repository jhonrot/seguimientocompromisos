<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo_trabajo extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    public function organismos()
    {
        return $this->hasMany(Organismo::class, 'id','organismo_id');
    }
}
