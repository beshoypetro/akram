<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Uuid;

/**
 * Class Invite
 * @package App\Models
 * @version August 18, 2017, 11:17 am UTC
 * @method static Invite find($id = null, $columns = array())
 * @method static Invite|\Illuminate\Database\Eloquent\Collection findOrFail($id, $columns = ['*'])
 * @property string token
 * @property string name
 * @property string email
 */
class Invite extends Model
{
    use SoftDeletes;
    use Notifiable;


    public $table = 'invites';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'organization_id',
        'token',
        'name',
        'email',
        'accepted',
        'accepted_at',
        'expiration'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'organization_id' => 'integer',
        'token' => 'string',
        'name' => 'string',
        'email' => 'string',
        'accepted' => 'boolean',
        'accepted_at' => 'date',
        'expiration' => 'date'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'token' => 'index',
        'email' => 'email',
    ];

    protected function generateToken()
    {
        $token = Uuid::uuid4(); //str_random(10);
        if (Invite::where('token', $token)->first()) {
            return $this->generateToken();
        }
        return $token;
    }


}
