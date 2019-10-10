<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function passwordSecurity ()
    {
        return $this->hasOne('App\PassworddSecurity');
    }
     public function specifiedFile ()
    {
        return $this->hasOne('App\specifiedFile','foreign_key','local_key');
    }

}
