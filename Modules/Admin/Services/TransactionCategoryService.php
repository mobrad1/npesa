<?php


namespace Modules\Admin\Services;


use App\Models\TransactionCategory;
use App\Services\BaseService;

class TransactionCategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(TransactionCategory::class);
    }
}
