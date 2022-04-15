<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Modules\Customer\Entities\Customer;

class CustomerService extends BaseService
{

//    8 - View Customer Login Logs
//    9 - Send Mails to Customer
//    10 - Send Mails to Customers
//    11 - Schedule Mails
//    12 - Send Sms to Customers
//    13 - Send sms to Customer
//    14 - Send notifications to Customers
//    15 - Send notification to Customer
//    16 - Customers Statistics (Broken down into Filters)


    public function __construct()
    {
        parent::__construct(Customer::class);
    }
    public function update(array $attributes,Customer $customer)
    {
        $customer->update($attributes);
        $customer->save();
        return $customer;
    }
    public function ban(Customer $customer)
    {
        $customer->ban();
        return $customer;
    }
    public function transactions(Customer $customer)
    {
        return $customer->transactions()->get();
    }

}
