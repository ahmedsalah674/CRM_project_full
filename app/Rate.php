<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    //protected $table='rate';
    protected $fillable = [
        'user_id','rate','ActiveReplays',
    ];
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
