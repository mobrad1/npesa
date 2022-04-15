<?php

namespace Modules\Customer\Http\Controllers;

use App\Services\Helpers\OTPService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Entities\Customer;

class ForgotPasswordController extends Controller
{
    public OTPService $otpService;
    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendOTP(Request $request)
    {
       $request->validate([
              'phone' => 'required|exists:customers',
        ]);

        return $this->otpService->sendOTP($request->phone);
    }

    public function updatePassword(Request $request)
    {
         $request->validate([
              'phone' => 'required|exists:customers',
              'pin' => 'required|string|min:4|confirmed',
              'pin_confirmation' => 'required',
              'otp' => 'required'
         ]);

        $phone = $request->phone;
        $otp =$request->otp;
        $verifyOtp = $this->otpService->verifyOTP($phone,$otp);

        if($verifyOtp["status"]){
            $customer = Customer::where('phone', $request->phone)
                      ->update(['pin' => Hash::make($request->pin)]);

            if($customer){
               return $this->sendResponse($verifyOtp,'Pin Reset Successfully');
            }
        }

        return $verifyOtp;
    }
}
