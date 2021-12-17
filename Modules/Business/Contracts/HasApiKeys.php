<?php
namespace Modules\Business\Contracts;

use Illuminate\Database\Eloquent\Relations\Relation;


interface HasApiKeys
{
    
    
    /**
     * setKeys
     *
     * @return void
     */
    public function setKeys(
        string $livePublicKey,
        string $liveSecretKey,
        string $testPublicKey,
        string $testSecretKey
    );

    
    /**
     * testKeys
     *
     * @return Relation
     */
    public function testKey();
    
    /**
     * liveKeys
     *
     * @return Relation
     */
    public function liveKey();
}