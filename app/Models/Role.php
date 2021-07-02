<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UsesUuid;
    protected $fillable = [];
    protected $guarded = [];
    protected $hidden = [
        'id'
    ];

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_roles');
    }
}
