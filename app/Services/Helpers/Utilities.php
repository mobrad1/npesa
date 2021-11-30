<?php
namespace App\Services\Helpers;

use Exception;

class Utilities
{

    
    /**
     * Converts from naira to kobo
     *
     * @param float $nairaValue The amount to be kobo
     *
     * @return int
     */
    public static function convertNaira2Kobo(float $nairaValue)
    {
        return intval(floatval($nairaValue) * 100);
    }
    
    /**
     * convertKobo2Naira
     *
     * @param  int $koboValue
     * @return float
     */
    public static function convertKobo2Naira(int $koboValue)
    {
        return floatval($koboValue/ 100);
    }

    
    /**
     * Format all phone numbers to a standard format
     *
     * @param  string $phone
     * @return void
     */
    public static function formatPhone(string $phone)
    {
        // if number has a plus we take it out
        if ($phone[0] == '+') {
            $phone = ltrim($phone, "+");
        }

        if (substr($phone, 0, 1) == "0") {
            $phone = "234".ltrim($phone, "0");
        }

        // if the number already has 234 we simply add plus
        if (substr($phone, 0, 3) == "234") return $phone;

        return $phone;
    }
    
        
    /**
     * Converts a string to a float
     *
     * @param  mixed $str
     * @return void
     */
    public static function stringToFloat(string $str)
    {
        return floatval(str_replace(',', '', $str));
    }
}