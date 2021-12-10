<?php
namespace Modules\Business\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Modules\Business\Entities\Business;
use Tests\TestCase;

class UpdateBankAccountTest extends TestCase

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
            'account_number'=> $faker->bankAccountNumber(),
            'bank_name'=> $faker->word(). ' Bank',
            'bank_code'=> strval($faker->randomNumber(3))
        ];
    }
    
    
    /**
     * Test we can update bank account information
     * @group business
     * @return void
     */
    public function test_we_can_update_bank_account_information()
    {

        $business = Business::factory()->ownerProfiled()->create();

        $payload = $this->getPayload();

        Sanctum::actingAs($business, ['*'], 'business');

        $uri = route('business.bank.account-update');

        $response = $this->json('POST', $uri, $payload);
       
        // assert response was successful
        $response->assertStatus(200);

        // assert data exists in the database
        $this->assertDatabaseHas('bank_accounts', $payload);
    }

   
}