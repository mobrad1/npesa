<?php
namespace Modules\Business\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Laravel\Sanctum\Sanctum;
use Modules\Business\Entities\Business;
use Tests\TestCase;

class VerifyEmailTest extends TestCase

{

    use RefreshDatabase;
    
    /**
     * Get business creation payload
     *
     * @return array
     */
    protected function getPayload()
    {
        //Create and already existsing business
        $business = Business::factory()->create();

        $password = 'password';
        return [
            'email'=> $business->email,
            'password'=> $password,
        ];
    }
    
    
    /**
     * We can signin a business with right payload
     * @group business
     * @return void
     */
    public function test_we_can_verify_an_email_address()
    {

        $business = Business::factory()->unverified()->create();

        // This assert unverified
        $this->assertDatabaseHas('businesses', [
            'business_name'=> $business->business_name,
            'email_verified_at'=> null
        ]);

        $uri = URL::signedRoute('business.verification.verify', ['id'=>$business->id, 'hash'=>sha1($business->email)]);
    
        $response = $this->json('PUT', $uri);
       
        // assert response was successful
        $response->assertStatus(200);

         // This assert verified
         $this->assertDatabaseHas('businesses', [
            'business_name'=> $business->business_name,
            'email_verified_at'=> now()
        ]);
    }

    /**
     *  Invalid details gives a 422 response
     * @group business
     * @return void
     */
    public function test_wrong_id_does_not_verify()
    {
        $business = Business::factory()->unverified()->create();

        $faker = \Faker\Factory::create();

        // This assert unverified
        $this->assertDatabaseHas('businesses', [
            'business_name'=> $business->business_name,
            'email_verified_at'=> null
        ]);

        $uri = URL::signedRoute('business.verification.verify', ['id'=>33, 'hash'=>sha1($business->email)]);
    
        $response = $this->json('PUT', $uri);
       
        // assert response was a bad response
        $response->assertStatus(400);

         // This assert unverified
         $this->assertDatabaseHas('businesses', [
            'business_name'=> $business->business_name,
            'email_verified_at'=> null
        ]);
    }


   
}