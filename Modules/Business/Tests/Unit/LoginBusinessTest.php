<?php
namespace Modules\Business\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Business\Entities\Business;
use Tests\TestCase;

class LoginBusinessTest extends TestCase

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
    public function test_we_can_signin_a_business_with_right_payload()
    {

        $payload = $this->getPayload();
        $uri = route('business.login');
        $response = $this->json('POST', $uri, $payload);
       
        // assert response was successful
        $response->assertStatus(200);
    }

    /**
     *  Invalid details gives a 422 response
     * @group business
     * @return void
     */
    public function test_missing_a_required_value_gives_422_response()
    {
        $payload = $this->getPayload();
        $payload['password'] = 'wrong_password';
        $uri = route('business.login');
        $response = $this->json('POST', $uri, $payload);
        
        // assert response was successful
        $response->assertStatus(422);
    }
}