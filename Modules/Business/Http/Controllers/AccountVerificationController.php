<?php

namespace Modules\Business\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\Helpers\OTPService;
use Illuminate\Http\Request;



class AccountVerificationController extends Controller
{
    public OTPService $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }
    public function verify(Request $request)
    {
         $request->validate([
              'phone' => 'required',
              'otp' => 'required'
         ]);

        $phone = $request->phone;
        $otp =$request->otp;
        $verifyOtp = $this->otpService->verifyOTP($phone,$otp);

        if($verifyOtp["status"]){
               return $this->sendResponse($verifyOtp,'Verification Successful');
        }

        return $verifyOtp;
    }
}
