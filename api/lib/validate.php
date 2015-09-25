<?php
namespace Lib;

use Lib\Exceptions\ValidateException;

class Validate
{
    public static function uint($data)
    {
        if (!is_null($data)) {
            $valid = filter_var($data, FILTER_VALIDATE_INT);
            if ($valid !== false && $valid > 0) {
                return $valid;
            }
        }
        throw new ValidateException();
    }

    public static function udouble($data)
    {
        try {
            if (!is_null($data)) {
                $numbers = explode('.', $data);
                if (count($numbers) <= 2) {
                    foreach ($numbers as $number) {
                        static::uint($number);
                    }
                    return $data;
                } 
            }
        } catch (ValidateException $e) {
            throw new ValidateException();
        }
        throw new ValidateException();
    }

    public static function image_url($data)
    {
        if (!is_null($data)) {
            $valid = '/^[a-zA-Z0-9\/.]+$/';
            $result = preg_match($valid, $data);
            if ($result === 1) {
                return $data;
            }
        }
        throw new ValidateException();
    }

    public static function plaintext($data)
    {
        if (!is_null($data)) {
            $valid = '/^[åäö\w\ ]+$/';
            $result = preg_match($valid, $data);
            if ($result === 1) {
                return $data;
            }
        }
        throw new ValidateException();
    }

    public static function password($data)
    {
        if (!is_null($data) && !empty($data)) {
            return $data;
        }
        throw new ValidateException();
    }
}
