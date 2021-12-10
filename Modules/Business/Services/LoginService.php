<?php
namespace Modules\Business\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Business\Entities\Business;
use Illuminate\Validation\ValidationException;

class LoginService 
{


    
    /**
     * Creates a user account
     *
     * @param  array $data
     * @return array
     */
    public function loginBusiness(array $data)
    {

        $business = Business::where('email', $data['email'])->first();

        if (! $business || ! Hash::check($data['password'], $business->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $business->createToken('Authenticiation')->plainTextToken;

        return $this->sendResponse($token, $business);
    }

    
    /**
     * Sends Response after account has been created
     *
     * @param  mixed $business
     * @return array
     */
    protected function sendResponse($token, $business)
    {
        return [
            'status'=> $token ? true : false,
            'message'=> $token ? "Account Logged In Successfully" : "An error occured creating account",
            'data'=> [
                'token'=> $token,
                'business'=> $business->toArray()
            ],
            'httpcode'=> $token ? 200 : 500
        ];
    }
}