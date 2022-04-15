<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CustomerUpdateRequest;
use Modules\Admin\Services\CustomerService;
use Modules\Customer\Entities\Customer;

class CustomerController extends Controller
{
    public $customerService;
    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index()
    {
        $customers = $this->customerService->all();
        return $this->sendResponse($customers,"Customers Loaded Successfully");
    }
    public function update(CustomerUpdateRequest $request,Customer $customer)
    {
        $data = $request->validated();
        $customer  = $this->customerService->update($data,$customer);
        return $this->sendResponse($customer,"User Updated Successfully");
    }
    public function delete($id)
    {
        $this->customerService->delete($id);
        return $this->sendResponse([],"Customer Deleted Successfully");
    }
    public function ban(Customer $customer)
    {
        $this->customerService->ban($customer);
        return $this->sendResponse($customer,"Customer Banned Successfully");
    }
    public function transactions(Customer $customer)
    {
        $transactions = $this->customerService->transactions($customer);
        return $this->sendResponse($transactions,"Transactions Loaded Successful");
    }
}
