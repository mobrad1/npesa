<?php
namespace Modules\Business\Services;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Entities\Business;

class RegistrationService
{



    /**
     * Creates a user account
     *
     * @param  array $data
     * @return array
     */
    public function createAccount(array $data)
    {
        // Create a user account
        $data['pin'] = Hash::make($data['pin']);
        $business = Business::create($data);

        event(new Registered($business));// fire the registration event

        return $this->sendResponse($business);
    }


    /**
     * Sends Response after account has been created
     *
     * @param  mixed $business
     * @return array
     */
    protected function sendResponse($business)
    {
        return [
            'status'=> $business ? true : false,
            'message'=> $business ? "Account Created Successfully" : "An error occured creating account",
            'httpcode'=> $business ? 200 : 500
        ];
    }
}
