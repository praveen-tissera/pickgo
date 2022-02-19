<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Package;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        // if(User::role() === "user"){

        // }else if(User::role() === "deliverer"){

        // }else if(User::role() === "admin"){

        // }else{
        //     //if the user role is not of the above 
        //     //abot with code 500
        //     abort(500);
        // }

            // for($i = 0; $i <= 9; $i++){
            //     Package::where('id', $i)->update([
            //         'lat' => 33 + rand(0, 1000000) / 1000000,
            //         'lng' => -6 - rand(0, 1000000) / 1000000,
            //     ]);
            // }
        
        

        return view('home');
    }
}
