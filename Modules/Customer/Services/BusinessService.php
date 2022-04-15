<?php


namespace Modules\Customer\Services;


use App\Services\BaseService;
use Modules\Business\Entities\Business;

class BusinessService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Business::class);
    }
    public function transactions(Business $business)
    {
        return $business->transactions()->get();
    }
}
