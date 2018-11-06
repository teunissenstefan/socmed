<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'poster');
    }

    public function comments(){
        return $this->hasMany('App\Comment','status','id')->orderBy('created_at','desc')->limit(2);
    }
}
