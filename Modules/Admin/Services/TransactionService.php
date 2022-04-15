<?php


namespace Modules\Admin\Services;


use App\Models\Transaction;
use App\Services\BaseService;

class TransactionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Transaction::class);
    }
}
