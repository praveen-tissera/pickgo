<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'logout' => 'Logout',

    //register error messages
    'firstname_required' => 'We need your first name',
    'firstname_min' => 'Your first name is too short',
    'lastname_required' => 'We need your last name',
    'last_min' => 'Your last name is too short',
    'adresse_min' => 'That does not look like a valid address',
    'email_required' => 'We need your email address',
    'email_email' => 'That does not look like a valid email',
    'password_required' => 'The password is required',
    'password_min' => 'The password must be at least 8 carachters',
    'cin_required' => 'The CIN number is required',
    'cin_min' => 'The CIN number is too short',
    'recaptcha' => 'The Captcha is required, Please solve it',
    'password_confirmed' => 'The Password fields do not match',
];
