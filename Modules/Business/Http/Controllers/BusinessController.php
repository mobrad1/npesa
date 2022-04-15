<?php

namespace Modules\Business\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Business\Http\Requests\BalanceRequest;
use Modules\Business\Http\Requests\BusinessUpdateRequest;
use Modules\Business\Services\BusinessService;
use Modules\Customer\Http\Requests\BuyAirtimeRequest;
use Modules\Customer\Http\Requests\PayBillRequest;
use Modules\Business\Http\Requests\SendMoneyToBankRequest;
use Modules\Business\Http\Requests\SendMoneyToMobileMoneyRequest;
use Modules\Business\Http\Requests\SendMoneyToMobileRequest;
use Modules\Customer\Http\Requests\PinRequest;

class BusinessController extends Controller
{
    public BusinessService $businessService;
    public function __construct(BusinessService $businessService)
    {
        $this->businessService = $businessService;
    }
   public function  update(BusinessUpdateRequest $request)
   {
        $data = $request->validated();
        $business = $this->businessService->update($data);
        return $this->sendResponse($business,"Business updated Successfully");
   }
    public function balance(BalanceRequest $request)
    {
        $data = $request->validated();
        try {
            $balance = $this->businessService->getBalance($data);
            return $this->sendResponse(["balance" => $balance], "Balance retrieved Successfully");

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }
    }
     public function sendMoneyToMobile(SendMoneyToMobileRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->sendMoneyToMobile($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function sendMoneyToBank(SendMoneyToBankRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->sendMoneyToBank($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function sendMoneyToMobileMoney(SendMoneyToMobileMoneyRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->sendMoneyToMobileMoney($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
     public function sendMoneyToBusiness(PayBillRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->sendMoneyToBusiness($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function payBill(PayBillRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->payBill($data);
            return $this->sendResponse([],"Bill payment successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function buyAirtime(BuyAirtimeRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->buyAirtime($data);
            return $this->sendResponse([],"Airtime Recharge successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function withdrawViaAgent(PayBillRequest $request)
    {
        $data = $request->validated();
        try{
            $this->businessService->withdrawViaAgent($data);
            return $this->sendResponse([],"Withdrawal to Agent successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function updatePin(PinRequest $request)
    {
        $data = $request->validated();
        try {
            $this->businessService->updatePin($data);
            //TODO logout all active sessions
            return $this->sendResponse([], "Pin Updated Successfully");

        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), []);
        }
    }
}
