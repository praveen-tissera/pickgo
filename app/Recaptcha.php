<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Recaptcha extends Model
{
    public static function validate($value)
    {
        $client = new Client;

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                    [
                        'secret' => config('admin.captcha-secret'),
                        'response' => $value
                    ]
            ]
        );

        $response = json_decode((string)$response->getBody());

        return $response;
    }
}
