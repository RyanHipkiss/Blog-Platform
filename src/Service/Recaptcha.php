<?php

namespace App\Service;

class Recaptcha
{
    const VERIFY_URI = 'https://www.google.com/recaptcha/api/siteverify?';
    const SITE_KEY = 'hello its me';
    const SECRET_KEY = '';

    public function __construct() {}

    public static function getSiteKey()
    {
        return self::SITE_KEY;
    }

    private static function getSecretKey()
    {
        return self::SECRET_KEY;
    }

    public static function isValidRequest($response)
    {
        if(empty($response)) {
            return false;
        }

        $query = http_build_query([
            'secret' => self::getSecretKey(),
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ]);

        $response = file_get_contents(self::VERIFY_URI . $query);
        $response = json_decode($response);

        if($response['success'] === false) {
            return false;
        }

        return true;
    }
}