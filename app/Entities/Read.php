<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reads';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	//protected $fillable = ['name', 'label']; // Still in definition

    public function permissions()
    {
    	return $this->belongsTo(Station::class);
    }
}
