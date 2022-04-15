<?php
namespace Modules\Business\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Modules\Business\Services\BusinessService;
use Modules\Business\Http\Requests\BusinessOwnerProfileRequest;

class ProfileController extends BaseController

{

    /**
     * Updates the Owner profile
     *
     * @param  mixed $request
     * @param  mixed $ownerService
     * @return void
     */
    public function ownerProfile(BusinessOwnerProfileRequest $request, BusinessService $ownerService)
    {

        try {

            $data = $request->getSanitized();

            $response = $ownerService->updateProfile($data);

            return $this->sendResponse($response);

        }catch(\Exception $e){

            if ($e instanceof ValidationException) {
                return $this->sendValidationException($e);
            }

            return $this->sendGenericException($e);
        }
    }
}
