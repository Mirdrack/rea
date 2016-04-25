<?php

namespace Rea\Entities;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'password_resets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = ['email', 'token'];

    public function setUpdatedAtAttribute($value)
    {
        // Do nothing because we don't need the updated_at attribute.
    }
}