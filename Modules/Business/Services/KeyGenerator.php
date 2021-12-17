<?php
namespace Modules\Business\Services;


class KeyGenerator 
{
    
    /**
     * Generates a set of key pairs
     *
     * @param  string $prefix
     * @return array
     */
    public static function getKeyPair($prefix)
    {
        $secretKey = 'NPSSECKEY_'.uniqid($prefix, true);
        $publicKey = 'NPSSPUBKEY_'.uniqid($prefix, true);
        return [$secretKey, $publicKey];
    }
}