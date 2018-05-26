<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission_role
 * @package App\Models
 * @version May 15, 2018, 2:28 pm UTC
 *
 */
class Permission_role extends Model
{
    use SoftDeletes;

    public $table = 'permission_roles';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'permission_id',
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
