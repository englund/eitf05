<?php
namespace Lib;

class Security
{
    public static function generate_salt()
    {
        $length = 8;
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $salt = '';
        for($i = 0; $i < $length; $i++) {
            $random = mt_rand(0, strlen($chars) - 1);
            $salt .= $chars[$random];
        }
        return $salt;
    }

    public static function hash($string)
    {
        return hash('sha512', $string);
    }
}
