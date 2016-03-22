<?php

namespace Rea\Entities;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


use Hash;

class User extends Model implements AuthenticatableContract, 
                                    AuthorizableContract, 
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function setPasswordAttribute($value)
    {   
        $this->attributes['password'] = Hash::make($value);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if(is_string($role))
            return $this->roles->contains('name', $role);
        else
            return !! $role->intersect($this->roles)->count();
    }

    public function giveRole(Role $role)
    {
        return $this->roles()->save($role);
    }

    public function retrieveRole(Role $role)
    {
        return $this->roles()->detach($role);
    }

    public function checkPermissions($permissions)
    {
        foreach ($permissions as $permission)
        {
            $can = $this->can('users');
            $userPermissions[$permission] = $this->can($permission); 
        }
        return $userPermissions;
    }
}
