<?php

namespace Modules\Business\Http\Controllers\Auth;


use Illuminate\Http\Request;
use Modules\Business\Services\LoginService;
use Illuminate\Validation\ValidationException;
use Modules\Business\Http\Requests\LoginRequest;
use Modules\Business\Services\RegistrationService;
use Modules\Business\Http\Requests\RegisterRequest;
use Modules\Business\Http\Controllers\BaseController;

class LoginController extends BaseController
{
      
   /**
    * Initial Account creation for a new business
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \Modules\Business\Services\LoginService $loginService
    * @return \Illuminate\Http\JsonResponse
    */
   public function login(LoginRequest $request, LoginService $loginService)
   {
        try {

            $data = $request->getSanitized();

            $response = $loginService->loginBusiness($data);

            return $this->sendResponse($response);

        }catch(\Exception $e){
            
            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }
            
            return $this->sendGenericException($e);
        }
   }
   
}
