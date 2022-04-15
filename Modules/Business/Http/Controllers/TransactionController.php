<?php

namespace Modules\Business\Http\Controllers;

use App\Filters\TransactionFilter;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Business\Services\BusinessService;
use Modules\Customer\Services\CustomerService;
use Modules\Customer\Services\TransactionService;

class TransactionController extends Controller
{
    public $transactionService;
    public $businessService;
    public function __construct(TransactionService $transactionService,BusinessService $businessService)
    {
        $this->transactionService = $transactionService;
        $this->businessService = $businessService;
    }
    public function index()
    {
        $transactions = $this->businessService->transactions();
        return $this->sendResponse($transactions,"Transaction loaded successfully");
    }
    public function search(TransactionFilter $filter)
    {
        $transactions = $this->businessService->search($filter);
        return $this->sendResponse($transactions,"Transactions Loaded successfully");
    }

}
