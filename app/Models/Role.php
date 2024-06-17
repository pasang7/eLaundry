<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['role_name'];



    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function rolePermission()
    {
        return $this->hasMany(RolePermission::class);
    }
}
