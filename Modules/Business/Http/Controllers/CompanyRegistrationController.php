<?php
namespace Modules\Business\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Business\Services\CompanyRegService;
use Modules\Business\Services\BusinessService;
use Modules\Business\Http\Requests\CompanyRegRequest;
use Modules\Business\Http\Requests\BusinessOwnerProfileRequest;

class CompanyRegistrationController extends BaseController

{

    /**
     * Upload company Registration Details
     *
     * @param  mixed $request
     * @param  mixed $ownerService
     * @return void
     */
    public function upload(CompanyRegRequest $request, CompanyRegService $regService)
    {

        try {

            $data = $request->getSanitized();

            $response = $regService->upload($data);

            return $this->sendResponse($response);

        }catch(\Exception $e){

            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }

            return $this->sendGenericException($e);
        }
    }
}
