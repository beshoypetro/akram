<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pre_order
 * @package App\Models
 * @version May 15, 2018, 2:18 pm UTC
 *
 */
class PreOrder extends Model
{
    use SoftDeletes;

    public $table = 'preOrders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'product_id',
        'user_id',
        'order_id'

    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'product_id' => 'required',
        'user_id' => 'required',
        'order_id' => 'required'
    ];

    
}
