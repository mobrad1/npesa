<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\BusinessCreateRequest;
use Modules\Admin\Http\Requests\BusinessUpdateRequest;
use Modules\Customer\Services\BusinessService;


class BusinessController extends Controller
{
    public $businessService;
    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }

    public function index()
    {
        $businesses = $this->businessService->all();
        return $this->sendResponse($businesses,"Businesses Loaded Successfully");
    }

    public function update(BusinessUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $business = $this->businessService->storeOrUpdate($data,$id);
        return $this->sendResponse($business,"Update Successful");
    }
    public function store(BusinessCreateRequest $request){
        $data = $request->validated();
        $business = $this->businessService->storeOrUpdate($data);
        return $this->sendResponse($business,"Created Successfully");
    }
    public function delete($id)
    {
        $this->businessService->delete($id);
        return $this->sendResponse([],"Business Deleted Successfully");
    }
}
