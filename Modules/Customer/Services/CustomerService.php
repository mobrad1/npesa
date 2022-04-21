<?php


namespace Modules\Customer\Services;


use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Entities\Customer;

class CustomerService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Customer::class);
    }
    public function storeOrUpdate(array $attributes, int $id = null)
    {
        $model = $id == null ? new $this->class :  $this->find($id);
        $model->fill($attributes);
        $model->save();
        return $model;
    }
    public function update(array $attributes)
    {
        $customer = $this->find(auth('customer')->id());
        $customer->fill($attributes);
        $customer->save();
        return $customer;
    }
    public function sendMoneyToMobile(array $attributes)
    {
        $customer = auth('customer')->user();
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $customer->pin)) {
           if($customer->phone === $attributes['phone']){
               throw new Exception("You can't send money to yourself");
           }
           if($transaction = $customer->sendMoney($attributes['amount'],$attributes['phone'],$attributes['channel'])){
               return $transaction;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");


    }
    //$amount,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA",$toAccount = null,$fromAccount=null
    public function sendMoneyToBank(array $attributes)
    {
        $customer = auth('customer')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$customer->pin))
        {
            if($transaction = $customer->sendMoneyToBank($attributes['amount'],$attributes['channel'],$attributes['account_number'],"AGOGA",$attributes['bank'])){
               return $transaction;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }

    public function sendMoneyToMobileMoney(array $attributes)
    {
        $customer = auth('customer')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$customer->pin))
        {
            if($transaction = $customer->sendMoneyToMobileMoney($attributes['amount'],$attributes['channel'],$attributes['account_number'],"AGOGA",$attributes['mobile_money'])){
               return $transaction;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function buyAirtime(array $attributes)
    {
        $customer = auth('customer')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$customer->pin))
        {
            if($transaction = $customer->buyAirtime($attributes['amount'],$attributes['channel'],$attributes['mobile_number'],"AGOGA",$attributes['airtime_provider'])){
               return $transaction;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function payBill(array $attributes)
    {
        $customer = auth('customer')->user();
        $accountNumber = isset($attributes['account_number']) ? $attributes['account_number'] : null;
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $customer->pin)) {
           if($transaction = $customer->payBill($attributes['amount'],$attributes['business_number'],$attributes['channel'],$accountNumber)){
               return $transaction;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function withdrawViaAgent(array $attributes)
    {
        $customer = auth('customer')->user();
        $accountNumber = isset($attributes['account_number']) ? $attributes['account_number'] : null;
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $customer->pin)) {
           if($transaction = $customer->withdrawViaAgent($attributes['amount'],$attributes['business_number'],$attributes['channel'],$accountNumber)){
               return $transaction;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function transactions()
    {
        return auth('customer')->user()->transactions()->get();
    }
    public function getBalance(array $attributes)
    {
        $customer = auth('customer')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'], $customer->pin)){
            return $customer->balance;
        }
        throw new Exception("Pin incorrect");
    }
    public function search($filter)
    {
        return auth('customer')->user()->transactions()->filter($filter)->get();
    }
    public function updatePin($attributes)
    {

         $customer = $this->find(auth('customer')->id());

         $hasher = app('hash');
        if ($hasher->check($attributes['old_pin'], $customer->pin)) {
           $customer->fill([
            'pin' => Hash::make($attributes['pin'])
           ]);
           $customer->save();
           return;
        }
        throw new Exception("Old pin Incorrect");
    }
}
