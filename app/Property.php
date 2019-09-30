<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public $timestamps = false;

    public $with = ['project', 'region', 'status', 'propertyType'];

    const YES = 1;
    const NO =0;

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function region(){
        return $this->belongsTo('App\Region');
    }

    public function status(){
        return $this->belongsTo('App\Status');
    }

    public function propertyType(){
        return $this->belongsTo('App\PropertyType');
    }

}
