<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ForgotPasswordController extends Controller
{
    //
    public $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function sendResetPasswordEmail(Request $request)
    {
        $validator = Validator::make($request->all(),$this->rules());

        if($validator->fails()){
            return $this->sendError($validator->errors()->all());
        }

        $email = $validator->validated()["email"];
        $user = User::where("email",$email)->first();

        $this->otpService->sendOtp($user);
        return $this->sendResponse([],"A password reset code has been sent to your mail");
    }

    public function rules()
    {
        return [
            "email" => "required|email|exists:users"
        ];
    }

}
