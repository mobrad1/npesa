<?php


namespace Modules\Admin\Services;


use App\Models\BusinessCategory;
use App\Services\BaseService;

class BusinessCategoryService extends BaseService
{
    public function __construct()
    {
        parent::__construct(BusinessCategory::class);
    }
}
