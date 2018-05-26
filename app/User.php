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
    public $fillable = [
        'organization_id',
        'role_id',
        'uuid',
        'user_name',
        'first_name',
        'last_name',
        'email',
        'password',
        'is_admin',
        'is_owner',
        'avatar_url',
        'bio',
        'job_title',
        'phone_number',
        'address',
        'date_of_birth'
    ];

    protected $casts = [
        'role_id' => 'integer',
        'uuid' => 'string',
        'user_name' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'email' => 'string',
        'is_admin' => 'boolean',
        'is_owner' => 'boolean',
        'avatarUrl' => 'url',
        'bio' => 'string',
        'jobTitle' => 'string',
        'phoneNumber' => 'string',
        'address' => 'string',
        'dateOfBirth' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $createRules = [
        'userName' => 'required|max:30',
        'firstName' => 'required|max:15',
        'lastName' => 'required|max:15',
        'password' => 'required|min:4',
        'email' => 'required|unique:users',
        'phoneNumber' => 'min:11|max:13',

    ];


    public static $updateRules = [
        'userName' => 'required|max:30',
        'firstName' => 'required|max:15',
        'lastName' => 'required|max:15',
        'password' => 'required|min:4',
        'passwordConfirmation' => 'required|same:password',
        'phoneNumber' => 'min:11|max:13',
        'email' => 'required|email'
        // |unique:users'
    ];

    public static $createAPIRules = [
        'userName' => 'required|max:30|unique:Organization',
        'email' => 'required|unique:users',
        'password' => 'required|min:4',
        'password_confirmation' => 'required|same:password',
        'is_admin' => 'required',
        'is_owner' => 'required',
        'phoneNumber' => 'min:11|max:13'

    ];

    public static $UserToOrganizationAPIrules = [
        'subDomain' => 'required',
        'firstName' => 'required',
        'lastName' => 'required',
        'userName' => 'required|unique:organizations',
        'email' => 'required|email|unique:users',
        'password' => 'required',
    ];

    public static $editProfileRules = [
//        'user_name' => 'required|max:30',
//        'first_name' => 'required|max:15',
//        'last_name' => 'required|max:15',
//        'password' => 'required|min:4',
//        'password_confirmation' => 'required|same:password',
//        'phone_number'=>'required|min:11|max:13',
        'email' => 'required',
//        'avatarUrl' =>'required',
//        'bio'=>'required',
//        'job_title'=>'required',
//        'address'=>'required',
//        'date_of_birth'=>'required',
    ];


    public static $updatePasswordAPIRules = [
        'password' => 'required|min:4',
        'passwordConfirmation' => 'required|same:password',
    ];

    public static $resetPasswordAPIRules = [
        'email' => 'required',
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
