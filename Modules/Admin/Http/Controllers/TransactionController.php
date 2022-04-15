<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Services\TransactionService;

class TransactionController extends Controller
{
    public $transactionService;
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = $this->transactionService->all();
        return $this->sendResponse($transactions,"Transactions Loaded successfully");
    }

    public function show($id)
    {
        $transaction = $this->transactionService->find($id);
        return $this->sendResponse($transaction,"Transaction Loaded Successfully");
    }
}
