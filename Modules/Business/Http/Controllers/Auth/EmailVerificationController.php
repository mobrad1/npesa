<?php

namespace Modules\Business\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Modules\Business\Services\LoginService;
use Illuminate\Validation\ValidationException;
use Modules\Business\Entities\Business;
use Modules\Business\Http\Requests\LoginRequest;
use Modules\Business\Services\RegistrationService;
use Modules\Business\Http\Requests\RegisterRequest;
use Modules\Business\Http\Controllers\BaseController;

class EmailVerificationController extends BaseController
{
      
   /**
    * Initial Account creation for a new business
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Modules\Business\Services\LoginService $registerService
    * @return \Illuminate\Http\JsonResponse
    */
   public function verify(Request $request)
   {
        try {

            $business = Business::find($request->id);

            if ($business) {
                $business->update(['email_verified_at'=> now()]);
                return $this->sendResponse([
                    'status'=> true,
                    'httpcode'=> 200,
                    'message'=> 'Email verification was successful'
                ]);
            }

            return $this->sendResponse([
                'status'=> false,
                'httpcode'=> 400,
                'message'=> 'Invalid signature'
            ]);

        }catch(\Exception $e){
          
            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }
            
            return $this->sendGenericException($e);
        }
   }

   
   /**
    * test
    *
    * @param  mixed $request
    * @return void
    */
   public function test(Request $request)
   {
       return $this->sendResponse(['status'=> true, 'message'=> 'Can access this route', 'httpcode'=>200]);
   }
   
}
