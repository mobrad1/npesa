<?php

namespace Modules\Business\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Modules\Business\Http\Requests\RegisterRequest;
use Modules\Business\Services\RegistrationService;

class RegisterController extends BaseController
{
      
   /**
    * Initial Account creation for a new business
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Modules\Business\Services\RegistrationService $registerService
    * @return \Illuminate\Http\JsonResponse
    */
   public function register(RegisterRequest $request, RegistrationService $registerService)
   {
        try {

            $data = $request->getSanitized();

            $response = $registerService->createAccount($data);

            return $this->sendSuccessResponse($response);

        }catch(\Exception $e){
            
            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }
            
            return $this->sendGenericException($e);
        }
   }
   
}
