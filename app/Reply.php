<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class Reply extends Model
{
  // protected $table='replies';
  //protected $table='complain_replay';
    protected $fillable = [
        'complain_id','reply',
      ];
      public function complain()
        { 
            return $this->belongsTo('App\Complain', 'complain_id');
            
        }
}
