<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'store_id',
        'vehicle_id',
        'phone',
        'address',
        'address_specific'
    ];

    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'role' => 'string',
        'created_at' => 'date',
        'updated_at' => 'date',
    ];

    public static $rules = [
        'name' => 'required|string',
        'email' => 'required|email',
//        'role' => 'required',
//        'created_at' => 'required',
//        'updated_at' => 'required'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany('App\models\Role');
    }
}
