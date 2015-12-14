<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name', 'label'];

    public function permissions()
    {
    	return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo(Permission $permission)
    {
    	return $this->permissions()->save($permission);
    }

    public function retrievePermissionTo(Permission $permission)
    {
        return $this->permissions()->detach($permission);
    }
}
