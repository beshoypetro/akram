<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Store
 * @package App\Models
 * @version May 15, 2018, 2:20 pm UTC
 *
 * @property string name
 * @property string location
 */
class Store extends Model
{
    use SoftDeletes;

    public $table = 'stores';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
        'location',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'user_id' => 'integer',
        'product_id' => 'integer',
        'location' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'product_id' => 'integer',
        'location' => 'required'
    ];

    public function products(){
        return $this->hasMany('App\Models\Products');
    }
    public function user(){
        return $this->belongsTo('App\User' , 'user_id');
    }
}
