<?php
namespace Modules\Business\Tests\Unit;

use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Modules\Business\Entities\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Business\Events\CompanyRegistered;

class CompanyDetailsTest extends TestCase

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
            'reg_type'=> $faker->randomElement(['CAC', 'BN', 'RC']),
            'reg_number'=> strval($faker->randomNumber(5)),
            'reg_file'=> UploadedFile::fake()->image('file.jpg'),
           
        ];
    }
    
    
    /**
     * Test we can upload company registration details
     * @group business
     * @return void
     */
    public function test_we_can_upload_company_registration_details()
    {
        Event::fake();
        
        $business = Business::factory()->ownerProfiled()->create();

        $payload = $this->getPayload();
        $payload['business_id']= $business->id;

        Sanctum::actingAs($business, ['*'], 'business');

        $uri = route('business.company.reg-upload');

        $response = $this->json('POST', $uri, $payload);

        // assert response was successful
        $response->assertStatus(200);

        // assert data exists in the database
        $payload =  $this->unsetMultiple($payload, 'reg_file');
        $this->assertDatabaseHas('company_reg_details', $payload);

        Event::assertDispatched(CompanyRegistered::class);
    }

   
}