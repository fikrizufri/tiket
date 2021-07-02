<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use UsesUuid;

    protected $fillable = [];
    protected $guarded = [];

    protected $hidden = [
        'id'
    ];

    public function role()
    {

        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_permissions');
    }
}
