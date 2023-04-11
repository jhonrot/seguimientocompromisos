<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paa extends Model
{
    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'id','presupuesto_id');
    }
}
