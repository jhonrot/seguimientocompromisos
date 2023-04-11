<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clasificacion extends Model
{
    protected $table = "clasificaciones";

    public function indices()
    {
        return $this->hasMany(Indice::class, 'id','indice_id');
    }
}
