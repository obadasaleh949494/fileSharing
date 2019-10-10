<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class specifiedFile extends Model
{
    //
     protected $table = 'specifiedfiles';

    public function owner()
{
    return $this->belongsTo('App\user', 'id', 'owner_id');
}
public function receiver()
{
   return $this->belongsTo('App\user', 'id', 'receiver_id');
}
public function file()
{
   return $this->belongsTo('App\file', 'id', 'file_id');
}
}
