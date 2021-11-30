<?php
namespace App\Services\Helpers;

use App\Jobs\SendSMS;
use OTPHP\TOTP;
use App\Models\PhoneSecret;
use App\Services\Helpers\Utilities;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;

class OTPService 
{

    public const OTPString = 'Your One-Time-Password code is ';

    
    /**
     * Sends OTP to a specific phone number
     *
     * @param string $phone [explicite description]
     *
     * @return array
     */
    public function sendOTP($phone)
    {
        $phone  = Utilities::formatPhone($phone);
        $res = $this->generateOTPCode($phone);

        $this->setPhone($phone, true);

        $code = $res['code'];

        $message = static::OTPString.$code;

        // TODO Send OTP Using sender channel
        //Queue::push(new SendSMS($phone, $message));
        
        return [
            'status'=> true,
            'message'=> $message,
            'data'=> [
                'code'=> $code
            ],
            'httpcode'=> 200
        ];
    }
    
    /**
     * Retrieves or creates a new secret for a particular phone number
     *
     * @param string $phone [explicite description]
     *
     * @return string
     */
    public function getPhoneSecret($phone)
    {
        $secret = PhoneSecret::where('phone', $phone)->first();
        if($secret) {
            return $secret->secret;
        }

        // Create another secret
        $secret = PhoneSecret::create([
            'phone'=> $phone,
            'secret'=> $this->getSecret()
        ]);

        return $secret->secret;
    }
    
    /**
     *  Generates an OTP for the phone by using the phone's stored secrets
     *
     * @return array
     */
    protected function generateOTPCode($phone)
    {
        $timestamp = time();
        $secret = $this->getPhoneSecret($phone);
        $otp = $this->createSecret($secret);
        $code = $otp->at($timestamp);
        return ['code'=> $code];
    }
    
    /**
     * Retrieves a secret
     *
     * @return string
     */
    public function getSecret()
    {
        $secret = $this->createSecret();
        return $secret->getSecret();
    }
    
    /**
     * Creates a new otp
     *
     * @param $secret=null $secret [explicite description]
     *
     * @return void
     */
    protected function createSecret($secret=null)
    {
        $seconds = config('settings.otp')['lifetime'] ?? 30; // 30 seconds
        $digits = config('settings.otp')['digits'] ?? 4; // number of otp digits
        $otp = TOTP::create($secret, $seconds, 'sha1', $digits);
        return $otp;
    }

    
    /**
     * Verify the OTP sent against given secret
     *
     * @param string $phone [explicite description]
     * @param string $input [explicite description]
     *
     * @return bool
     */
    public function verifyOTP($phone, $input)
    {
        $phone = Utilities::formatPhone($phone);

        $secret = $this->getPhoneSecret($phone);

        $timestamp = time();
      
        if(!$secret) {
            return ['status'=> false, 'message'=> 'Invalid secret', 'httpcode'=> 422];
        }

        $otp = $this->createSecret($secret);

        $verify =  $otp->verify($input, $timestamp);
        
        if(! $verify) {
            return [
                'status'=> false,
                'message'=> 'Invalid OTP Supplied',
                'httpcode'=> 403
            ];
        }

        $this->setPhone($phone, false);

        return [
            'status'=> true,
            'message'=> 'Verification successful',
            'httpcode'=> 200
        ];
    }

    
    /**
     * The phone 
     *
     * @param  string $phone
     * @param  string $flip
     * @return void
     */
    protected function setPhone($phone, $flip)
    {
        $key = $phone.'-verify-status';
        Cache::put($key, $flip, 600);
    }
}