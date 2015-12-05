<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stations';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['name'];

    public function permissions()
    {
    	return $this->hasMany(Read::class);
    }
}