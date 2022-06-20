<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    protected $table = 'permissions';
    public $timestamps = false;

    public function role()
    {
        return $this->belongsToMany(Role::class,'permissionrole');
    }
}
