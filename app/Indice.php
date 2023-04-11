<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Indice extends Model
{
    public function equipos()
    {
        return $this->hasMany(Equipo_trabajo::class, 'id','equipo_id');
    }
}
