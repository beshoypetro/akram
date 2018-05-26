<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Role_user
 * @package App\Models
 * @version May 15, 2018, 2:25 pm UTC
 *
 */
class Role_user extends Model
{
    public $table = 'role_user';
    public $timestamps = false;

    public $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
