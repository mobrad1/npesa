<?php
namespace Modules\Business\Tests\Unit;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class CreateBusinessTest extends TestCase

{

    use RefreshDatabase;
    
    /**
     * Get business creation payload
     *
     * @return array
     */
    protected function getPayload()
    {
        $faker = \Faker\Factory::create();
        $password = 'password';
        return [
            'business_name'=> $faker->name(). ' Enterprise',
            'email'=> $faker->unique()->safeEmail(),
            'password'=> $password,
            'password_confirmation'=> $password
        ];
    }
    
    
    /**
     * test_we_can_create_a_business_account
     * @group business
     * @return void
     */
    public function test_we_can_create_a_business_account()
    {

        Event::fake();

        $payload = $this->getPayload();
        $uri = route('business.create');
        $response = $this->json('POST', $uri, $payload);
       
        // assert registered event was fired
        Event::assertDispatched(Registered::class);
        
        // assert response was successful
        $response->assertStatus(200);

        // assert data exists in the database
        $payload = $this->unsetMultiple($payload,'password', 'password_confirmation');
        $this->assertDatabaseHas('businesses', $payload);
    }

    /**
     * Missing a required value gives a 422 response
     * @group business
     * @return void
     */
    public function test_missing_a_required_value_gives_422_response()
    {
        $payload = $this->getPayload();
        unset($payload['business_name']);
        $uri = route('business.create');
        $response = $this->json('POST', $uri, $payload);

        // assert response was successful
        $response->assertStatus(422);
    }
}