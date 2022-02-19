<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Recaptcha;
use App\User;
use Validator;

class AuthController extends Controller
{
    /**
     * 
     * this function logs a user in
     */
    public function login(Request $request)
    {
        if($user = User::login(['email' => request('email'), 'password' => request('password')])){
            //login and send the token
            //$user = Auth::user(); 
            $data['token'] =  $user->createToken('MyApp')->accessToken;

            return response()->json([
                'data' => $data,
                'user' => $user,
            ], 200); 
        } 
        else{ 
            return response()->json([
                'error' => 'Unauthorised'
            ], 401); 
        } 
    }

    /**
     * 
     * this function registers a user
     */
    public function register(Request $request)
    {
        if($request->isMethod('get')){
            return view('auth.register');
        }else if($request->isMethod('post')){

            //validate the request
            $validator = Validator::make($request->all(), [ 
                'firstname' => 'required|string|min:3',
                'lastname' => 'required|string|min:3',
                'adresse' => 'string|min:3',
                'email' => 'required|email',
                'password' => 'required|confirmed|min:8',
                'phone' => 'required|string',
                'cin' => 'required|min:3',
                'g-recaptcha-response' => 'required',
            ],[//add custom error messages
                'firstname.required' => trans('auth.firstname_required'),
                'firstname.min' => trans('auth.firstname_min'),
                'lastname.required' => trans('auth.lastname_required'),
                'lastname.min' => trans('auth.last_min'),
                'adresse.min' => trans('auth.adresse_min'),
                'email.required' => trans('auth.email_required'),
                'email.email' => trans('auth.email_email'),
                'password.required' => trans('auth.password_required'),
                'password.min' => trans('auth.password_min'),
                'password.confirmed' => trans('auth.password_confirmed'),
                'cin.required' => trans('auth.cin_required'),
                'cin.min' => trans('auth.cin_min'),
                'g-recaptcha-response' => trans('auth.recaptcha')
            ]);

            //send the errors if there are any
            if ($validator->fails()) {
                if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){ //coming from the browser
                    return redirect()->back()->withInput()->withErrors($validator);
                }else{
                    return response()->json([
                        'error' => $validator->errors()
                    ], 401);
                }
            }

            //validate the captcha
            $res = Recaptcha::validate($request->input('g-recaptcha-response'));
            if(!$res->success){
                return redirect()->back();
            }

            //register the user
            $input = $request->all();
            $user = User::register($input);

            if(!(isset($request->header()['content-type'][0]) && $request->header()['content-type'][0] === "application/json")){ //coming from the browser
                User::login(['email' => $request->email, 'password' => $request->password]);

                return redirect()->route('home');
            }else{ // coming from the api

                //generate the token
                $data['token'] =  $user->createToken('MyApp')->accessToken;

                return response()->json([
                    'data' => $data
                ], 200);
            }
        }
    }

    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function details() 
    { 
        $user = Auth::user();

        return response()->json([
            'success' => $user
        ], 200); 
    }
}
