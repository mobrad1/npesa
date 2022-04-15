<?php

namespace Modules\Business\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Customer\Http\Requests\LocationRequest;
use Modules\Business\Services\LocationService;

class LocationController extends Controller
{
    public $locationService;
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    public function findATM(LocationRequest $request)
    {
        $data = $request->validated();
        $businesses = $this->locationService->findATM($data);
        return $this->sendResponse($businesses,"ATM loaded succesfully");
    }
    public function findBank(Request $request)
    {
        $data = $request->validated();
        $businesses = $this->locationService->findATM($data);
        return $this->sendResponse($businesses,"Bank loaded succesfully");
    }
    public function findAgent(Request $request)
    {
        $data = $request->validated();
        $businesses = $this->locationService->findATM($data);
        return $this->sendResponse($businesses,"Agent loaded succesfully");
    }
    public function findBusiness(Request $request)
    {
        $data = $request->validated();
        $businesses = $this->locationService->findATM($data);
        return $this->sendResponse($businesses,"Business loaded succesfully");
    }
}
