<?php

namespace App\Models\Simpusk;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Tymon\JWTAuth\Contracts\JWTSubject;
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table    = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
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
     public function role()
    {
        return $this->belongsToMany(Role::class, 'roleuser');
    }

    /*
        Permission and Akses
    */
    public function hasAkses($id)
    {
        foreach($this->akses as $role) {
            if ($role->id == $id) {
                return true;
            }
        }

        return false;
    }

    // ACL
    public function can($ability=null, $arguments = [])
    {
        return !is_null($ability) && $this->checkPermission($ability);
    }

    protected function checkPermission($perm)
    {
        $permissions     = $this->getAllPermissionsAllRoles();
        $permissionArray = is_array($perm) ? $perm : [$perm];

        return count(array_intersect($permissions, $permissionArray));
    }

    protected function getAllPermissionsAllRoles()
    {
        $permissionsArray = $this->role->load(['permission' => function ($query) { $query->select(['slug']); }])->pluck('permission')->toArray();
        $permissionsFlat  = array_map('strtolower', array_unique(Arr::flatten(array_map(function ($permission) {
            return Arr::pluck($permission, 'slug');
        }, $permissionsArray))));

        return $permissionsFlat;
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->contains('name', $role);
        }
        return !! $role->contains($this->role);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
