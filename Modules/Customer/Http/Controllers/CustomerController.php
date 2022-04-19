<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Customer\Http\Requests\BalanceRequest;
use Modules\Customer\Http\Requests\BuyAirtimeRequest;
use Modules\Customer\Http\Requests\CustomerUpdateRequest;
use Modules\Customer\Http\Requests\PayBillRequest;
use Modules\Customer\Http\Requests\PinRequest;
use Modules\Customer\Http\Requests\SendMoneyToBankRequest;
use Modules\Customer\Http\Requests\SendMoneyToMobileMoneyRequest;
use Modules\Customer\Http\Requests\SendMoneyToMobileRequest;
use Modules\Customer\Services\CustomerService;

class CustomerController extends Controller
{
    public $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }
    public function upgradeAccount()
    {
        return $this->sendResponse([],"Upgrade Request Made, Your account will be updated after verification");
    }
    public function update(CustomerUpdateRequest $request)
    {
        //
        $data = $request->validated();
        $customer  = $this->customerService->update($data);
        return $this->sendResponse($customer,"User Updated Successfully");

    }

    public function sendMoneyToMobile(SendMoneyToMobileRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->sendMoneyToMobile($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function sendMoneyToBank(SendMoneyToBankRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->sendMoneyToBank($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function sendMoneyToMobileMoney(SendMoneyToMobileMoneyRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->sendMoneyToMobileMoney($data);
            return $this->sendResponse([],"Money sent successfully");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function buyAirtime(BuyAirtimeRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->buyAirtime($data);
            return $this->sendResponse([],"Airtime Recharge successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function payBill(PayBillRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->payBill($data);
            return $this->sendResponse([],"Bill payment successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function withdrawViaAgent(PayBillRequest $request)
    {
        $data = $request->validated();
        try{
            $this->customerService->withdrawViaAgent($data);
            return $this->sendResponse([],"Withdrawal to Agent successful");
        }catch (\Exception $e){
            return $this->sendError($e->getMessage(),[]);
        }
    }
    public function balance(BalanceRequest $request)
    {
        $data = $request->validated();
        try {
             $balance = $this->customerService->getBalance($data);
             return $this->sendResponse(["balance" => $balance],"Balance retrieved Successfully");

        }catch (\Exception $e){
             return $this->sendError($e->getMessage(),[]);
        }
    }
    public function updatePin(PinRequest $request)
    {
        $data = $request->validated();
        try {
             $this->customerService->updatePin($data);
             //TODO logout all active sessions
             return $this->sendResponse([],"Pin Updated Successfully");

        }catch (\Exception $e){
             return $this->sendError($e->getMessage(),[]);
        }

    }

}
