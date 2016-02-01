<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function reads()
    {
    	return $this->hasMany(Read::class);
    }

    public function turnOn()
    {
        $updated = new Carbon($this->updated_at);
        $now = Carbon::now();
        if($updated->diff($now)->i < 60)
        {
            $this->status = true;
            $this->save();
            return true;
        }
        else
            return false;
    }

    public function turnOff()
    {
        $this->status = false;
        $this->save();
        return true;
    }
}