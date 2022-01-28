<?php


namespace App\Enums;


abstract class BaseEnum
{
    /**
     * Returns all enum values
     * @return array
     */
    public static function all()
    {
        $constants = (new \ReflectionClass(static::class))->getConstants();
        return array_values($constants);
    }

    /**
     * Validates an enum
     * @param $value
     * @param bool $caseInsensitive
     * @return bool
     */
    public static function validate($value, $caseInsensitive = true)
    {
        $values = self::all();
        if($caseInsensitive) {
            $value = strtoupper($value);
            $values = array_map('strtoupper', $values);
        }
        return in_array($value, $values);
    }
}
