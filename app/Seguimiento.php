<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seguimiento extends Model
{
    public function estado_seguimientos()
    {
        return $this->hasMany(Estado_seguimiento::class, 'id','estado_id');
    }

    public function temas()
    {
        return $this->hasMany(Tema::class, 'id','tema_id');
    }

    /*public function creator()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }*/

    public function evidencias()
    {
        return $this->hasMany(Seguimiento_archivo::class);
    }
}
