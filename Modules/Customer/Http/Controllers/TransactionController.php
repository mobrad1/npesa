<?php

namespace Modules\Customer\Http\Controllers;

use App\Filters\TransactionFilter;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Customer\Services\CustomerService;
use Modules\Customer\Services\TransactionService;

class TransactionController extends Controller
{
    public $transactionService;
    public $customerService;
    public function __construct(TransactionService $transactionService,CustomerService $customerService)
    {
        $this->transactionService = $transactionService;
        $this->customerService = $customerService;
    }
    public function index()
    {
        $transactions = $this->customerService->transactions();
        return $this->sendResponse($transactions,"Transaction loaded successfully");
    }
    public function search(TransactionFilter $filter)
    {
        $transactions = $this->customerService->search($filter);
        return $this->sendResponse($transactions,"Transactions Loaded successfully");
    }
}
