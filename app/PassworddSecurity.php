<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassworddSecurity extends Model
{
    //
    protected $fillable=['user_id','google2fa_enable','google2fa_secret'];
    public function user()
    {
    	return $this->belongsTo('App\user');
    }

}
