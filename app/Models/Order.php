<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Order
 * @package App\Models
 * @version May 15, 2018, 2:13 pm UTC
 *
 * @property string name
 * @property double price
 * @property string discription
 * @property integer delevary_time
 * @property tinyin shipped
 */
class Order extends Model
{
    use SoftDeletes;

    public $table = 'orders';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'price',
        'discription',
        'delevary_time',
        'shipped',
        'user_id',
        'store_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'price' => 'double',
        'discription' => 'string',
        'delevary_time' => 'integer',
        'user_id' => 'integer',
        'store_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'require',
        'price' => 'required',
        'discription' => 'required',
        'delevary_time' => 'integer',
        'shipped' => 'required',
        'user_id' => 'required',
        'store_id' => 'required'
    ];

    
}
