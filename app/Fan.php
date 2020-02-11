<?php

namespace App;

use App\Model;

class Fan extends Model
{
    //粉丝用户
    public function fuser(){
        return $this->hasone(\App\User::class,'id','fan_id');
    }

    //被关注用户
    public function suser(){
        return $this->hasone(\App\User::class,'id','star_id');
    }
}
