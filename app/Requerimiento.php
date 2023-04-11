<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Requerimiento extends Model
{
    public function creator()
    {
        return $this->hasMany(User::class, 'id','user_id');
    }
}
