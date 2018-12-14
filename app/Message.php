<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function sender(){
        return $this->belongsTo(User::class,'send_from');
    }

    public function receiver(){
        return $this->belongsTo(User::class,'send_to');
    }
}
