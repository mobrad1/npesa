<?php

namespace Modules\Customer\Http\Controllers;

use App\Filters\BusinessFilter;
use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Modules\Customer\Http\Requests\LocationRequest;


class LocationController extends Controller
{
    public $locationService;
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }
    public function findATM(BusinessFilter $filter)
    {

        $businesses = $this->locationService->findATM($filter);
        return $this->sendResponse($businesses,"ATM loaded successfully");
    }
    public function findBank(BusinessFilter $filter)
    {
        $businesses = $this->locationService->findBank($filter);
        return $this->sendResponse($businesses,"Bank loaded succesfully");
    }
    public function findAgent(BusinessFilter $filter)
    {
        $businesses = $this->locationService->findAgent($filter);
        return $this->sendResponse($businesses,"Agent loaded succesfully");
    }
    public function findBusiness(BusinessFilter $filter)
    {
        $businesses = $this->locationService->findBusiness($filter);
        return $this->sendResponse($businesses,"Business loaded succesfully");
    }
}
