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

    protected function generateOTPCode($phone)
    {
        $timestamp = time();
        $secret = $this->getPhoneSecret($phone);
        $otp = $this->createSecret($secret);
        $code = $otp->at($timestamp);
        return ['code'=> $code];
    }


    public function getSecret()
    {
        $secret = $this->createSecret();
        return $secret->getSecret();
    }


    protected function createSecret($secret=null)
    {
        $seconds = config('settings.otp')['lifetime'] ?? 60; // 30 seconds
        $digits = config('settings.otp')['digits'] ?? 4; // number of otp digits
        return TOTP::create($secret, $seconds, 'sha1', $digits);
    }



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
