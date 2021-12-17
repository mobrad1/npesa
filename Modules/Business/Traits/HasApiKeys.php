<?php
namespace Modules\Business\Traits;

use Modules\Business\Entities\LiveKey;
use Modules\Business\Entities\TestKey;
use Illuminate\Database\Eloquent\Relations\Relation;

trait HasApiKeys
{
    
    /**
     * Sets the Test and Live Keys
     *
     * @return void
     */
    public function setKeys(
        string $livePublicKey,
        string $liveSecretKey,
        string $testPublicKey,
        string $testSecretKey
    )
    {
        $this->liveKey()->delete(); //delete old live keys

        LiveKey::create([
            'public_key'=> $livePublicKey,
            'secret_key'=> $liveSecretKey,
            'owner_type'=> get_class($this),
            'owner_id'=> request()->user($this->guard)
        ]);

        $this->testKey()->delete(); // delete test  test keys
        TestKey::create([
            'public_key'=> $testPublicKey,
            'secret_key'=> $testSecretKey,
            'owner_type'=> get_class($this),
            'owner_id'=> request()->user($this->guard)
        ]);
    }

    
    /**
     * Gets the models live key
     *
     * @return Relation
     */
    public function liveKey()
    {
        return $this->morphOne(LiveKey::class, 'owner');
    }

    /**
     * Gets the models test key
     *
     * @return Relation
     */
    public function testKey()
    {
        return $this->morphOne(TestKey::class, 'owner');
    }
}