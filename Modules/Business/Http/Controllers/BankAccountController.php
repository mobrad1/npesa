<?php
namespace Modules\Business\Http\Controllers;

use App\Services\BankAccountService;
use Illuminate\Validation\ValidationException;
use Modules\Business\Http\Requests\BankAccountRequest;

class BankAccountController extends BaseController

{
    
    /**
     * Upload company Registration Details
     *
     * @param  mixed $request
     * @param  mixed $ownerService
     * @return void
     */
    public function update(BankAccountRequest $request, BankAccountService $accountService)
    {

        try {

            $data = $request->getSanitized();

            $response = $accountService->storeDetails($data);

            return $this->sendResponse($response);

        }catch(\Exception $e){
            
            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }
            
            return $this->sendGenericException($e);
        }
    }
}