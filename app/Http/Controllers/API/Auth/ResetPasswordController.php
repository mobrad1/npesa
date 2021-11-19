<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OTPService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    //
    public $otpService;
    public function __construct(OTPService $otpService)
    {
        $this->otpService =  $otpService;
    }

    public function verifyOtp()
    {
        $user = User::where("email",request("email"))->first();
        $code = request('code');

        if($this->otpService->verifyOTP($user,$code)){
          return $this->sendResponse([
              "token" => $this->createPasswordResetToken()
          ],"Code has been verified")  ;
        }
        return $this->sendError("The code is invalid");
    }
    public function createPasswordResetToken()
    {
        $user = User::where ('email', request("email"))->first();
        if ( !$user ) return redirect()->back()->withErrors(['error' => '404']);


        DB::table('password_resets')->insert([
            'email' => request('email'),
            'token' => Str::random(40),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')
                     ->where('email', request('email'))->first();

       return $tokenData->token;
    }
    public function reset() {
        $validator = Validator::make(request()->all(),$this->rules());
        if($validator->fails()){
            return $this->sendError($validator->errors()->all());
         }

         $updatePassword = DB::table('password_resets')
                              ->where([
                                'email' => request("email"),
                                'token' => request("token")
                              ])->first();

          if(!$updatePassword){
              return $this->sendError("Invalid token for email");
          }

          $user = User::where('email', request("email"))
                      ->update(['password' => Hash::make(request("password"))]);

          DB::table('password_resets')->where(['email'=> request("email")])->delete();


         return response()->json(["msg" => "Password has been successfully changed"]);
    }
    public function rules(){
        return [
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ];
    }
}
