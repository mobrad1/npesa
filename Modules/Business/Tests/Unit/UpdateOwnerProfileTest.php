<?php
namespace Modules\Business\Tests\Unit;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Modules\Business\Entities\Business;
use Tests\TestCase;

class UpdateOwnerProfileTest extends TestCase

{

    use RefreshDatabase;
    
    /**
     * Get owner update payload
     *
     * @return array
     */
    protected function getPayload()
    {
        $faker = \Faker\Factory::create();
        return [
            'first_name'=> $faker->firstName(),
            'last_name'=> $faker->lastName(),
            'phone'=> $faker->unique()->safeEmail(),
            'is_registered'=> $faker->randomElement([true, false]),
            'team_size'=> $faker->randomNumber(2)
        ];
    }
    
    
    /**
     * Test we can update profile business owner
     * @group business
     * @return void
     */
    public function test_we_can_update_profile_owner()
    {

        $payload = $this->getPayload();

        Sanctum::actingAs(Business::factory()->create(), ['*'], 'business');

        $uri = route('business.owner.profile-update');

        $response = $this->json('PUT', $uri, $payload);
       
        // assert response was successful
        $response->assertStatus(200);

        // assert data exists in the database
        $this->assertDatabaseHas('businesses', $payload);
    }

   
}