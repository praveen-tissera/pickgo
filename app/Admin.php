<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Admin extends Model
{
    /**
     * this function chages the role of the user from "user" to "deliverer"
     * @param int user id
     * @return boolean
     */
    public static function makeDeliverer($user)
    {
        return User::where('id', $user)->update([
            'role' => 'deliverer',
        ]);
    }

    /**
     * 
     * this function changes the role of the user from Deliverer to User
     * @param int user id
     * @return boolean
     */
    public static function removeDeliverer($user)
    {
        return User::where('id', $user)->update([
            'role' => 'user',
        ]);
    }
}
