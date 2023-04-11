<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'type_document', 'num_document', 'email', 'state', 'password','telefono','celular',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getName(){
        $names = explode(" ", $this->name);
        return $names[0];
    }

    public function roles_show():BelongsToMany
    {
       return $this->belongsToMany('Spatie\Permission\Models\Role','model_has_roles','model_id','role_id');
    }

    public function equipo_trabajos()
    {
        return $this->hasMany(Equipo_trabajo::class, 'id','equipo_trabajo_id');
    }

    public function organismos()
    {
        return $this->hasMany(Organismo::class, 'id','organismo_id');
    }

    public function temas(): BelongsToMany
    {
        return $this->belongsToMany(Tema::class);
    }

    public function getId(){
        return $this->id;
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'user_id','id');
    }
    
    public function asignador()
    {
        return $this->hasMany(Tema::class);
    }
}
