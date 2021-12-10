<?php


namespace Modules\Customer\Services;


use App\Services\BaseService;
use Modules\Customer\Entities\Customer;

class LoginService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Customer::class);
    }
}
