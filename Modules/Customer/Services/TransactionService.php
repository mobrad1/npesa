<?php


namespace Modules\Customer\Services;


use App\Models\Transaction;
use App\Services\BaseService;
use Illuminate\Support\Collection;

class TransactionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Transaction::class);
    }

}
