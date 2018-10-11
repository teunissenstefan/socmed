<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public function user(){
        return $this->belongsTo(User::class,'poster');
    }

    public function date(){
        //return \Carbon\Carbon::parse($created_at)->format('d-m-Y');
    }
}
