<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public $timestamps = false;
    public $with = ['country'];

    public function country(){
        return $this->belongsTo('App\Country');
    }
}
