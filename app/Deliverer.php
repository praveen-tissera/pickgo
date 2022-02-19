<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deliverer extends Model
{

    /**
     * The attribute that is the primary key
     * 
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * the table name
     * 
     * @var string
     */
    protected $table = 'users';

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
     * this function returns the deliverers
     * @param array deliverers
     * @return Deliverer
     */
    public static function deliverers($deliverers = null)
    {
        if(gettype($deliverers) === "object"){
            return Deliverer::whereIn('id', $deliverers)->get();
        }else if(gettype($deliverers) === "integer"){
            return Deliverer::where('id', $deliverers)->get();
        }

        return Deliverer::get();
    }

    /**
     * 
     * this function sends a welcome email to the new deliverer
     * @param User user
     * @return boolean
     */
    public static function sendDelivererWelcomeMail($user)
    {
        
    }
}
