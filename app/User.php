<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attribute that is the primary key
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'verified', 'email', 'password', 'phone', 'adresse', 'role', 'cin',
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

    /**
     * 
     * register a user
     * @param string firstname
     * @param string lastname
     * @param string phone
     * @param string email
     * @param string password
     * @param string adresse
     * @return User
     */
    public static function register($data)
    {
        return User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'adresse' => $data['adresse'],
            'cin' => $data['cin'],
        ]);
    }

    /**
     * 
     * login a user
     * @param string email
     * @param string password
     * @return User
     */
    public static function login($data)
    {
        if(Auth::attempt($data)){
            return Auth::user();
        }
    }

    /**
     * this function returns the user role ['admin', 'deliverer', 'user']
     * @param int user id
     * @return string role 
     */
    public static function role($id = null)
    {
        $role = Auth::user()->role;

        if(!isset($role)){
            $role = User::where('id', $id)->role;
        }

        return $role;
    }

    // /**
    //  * this function sets the user middlewares based on there role
    //  * @return void
    //  */
    // public static function initMiddlewares()
    // {
    //     //test the user role to define the middleware

    //     //user role
    //     $role = Auth::user()->role;

    //     if($role == "user"){
    //         //user middleware here
    //     }else if($role == "deliverer"){
    //         //deliverer middleware here
    //     }else if($role == "admin"){
    //         //admin middleware here
    //     }
    // }

    /**
     * this function returns the users that have a role of user with pagination
     * @return Collection users
     */
    public static function users($paginate)
    {
        return User::where('role', 'user')->paginate($paginate);
    }

    /**
     * 
     * this function returns the users that have a role of deliverers with pagination
     * @return Collection deliverers
     */
    public static function deliverers($paginate)
    {
        return User::where('role', 'deliverer')->paginate($paginate);
    }

    /**
     * 
     * this function returns a single user
     * @param int id
     */
    public static function userId($id)
    {
        return User::where('id', $id)->first();
    }
}
