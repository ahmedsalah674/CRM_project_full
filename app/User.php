<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role','image','rate','rate_number',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function getImageAttribute($value)
        {
          return asset('images/users/'.$value);
        }
    public function CustomerComplains()
    {
        return $this->hasMany('App\complain','customer_id');
    }
    public function EmployeeComplains()
    {
        return $this->hasMany('App\complain','employee_id');
    }
    public function rate()
    {
        return $this->hasOne('App\Rate','user_id');
    }
}
