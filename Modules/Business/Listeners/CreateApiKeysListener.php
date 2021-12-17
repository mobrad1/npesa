<?php

namespace Modules\Business\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Business\Entities\Business;
use Modules\Business\Services\KeyGenerator;
use Spatie\Crypto\Rsa\KeyPair;

class CreateApiKeysListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //
        [$liveSecretKey, $livePublicKey] = KeyGenerator::getKeyPair('LIVE_');

        [$testSecretKey, $testPublicKey] = KeyGenerator::getKeyPair('TEST_');
        
        $business = request()->user('business');

        $business->setKeys($livePublicKey, $liveSecretKey, $testPublicKey, $testSecretKey);
    }
}
