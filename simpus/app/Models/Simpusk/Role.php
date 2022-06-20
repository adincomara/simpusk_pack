<?php

namespace App\Models\Simpusk;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'roles';
    public $timestamps = false;

    public function user()
    {
        return $this->belongsToMany(User::class,'roleuser');
    }
    public function permission()
    {
        return $this->belongsToMany(Permission::class,'permissionrole');
    }

}
