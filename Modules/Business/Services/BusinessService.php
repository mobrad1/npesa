<?php
namespace Modules\Business\Services;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Hash;
use Modules\Business\Entities\Business;


class BusinessService extends BaseService
{
    public function __construct()
    {

        parent::__construct(Business::class);
    }
   public function update(array $attributes)
    {
        $business = $this->find(auth('business')->id());
        $business->fill($attributes);
        $business->save();
        return $business;
    }
    public function getBalance(array $attributes)
    {
        $business = auth('business')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'], $business->pin)){
            return $business->balance;
        }
        throw new Exception("Pin incorrect");
    }
    public function sendMoneyToMobile(array $attributes)
    {
        $business = auth('business')->user();
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $business->pin)) {
           if($business->phone === $attributes['phone']){
               throw new Exception("You can't send money to yourself");
           }
           if($business->sendMoneyToCustomer($attributes['amount'],$attributes['phone'],$attributes['channel'])){
               return;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");

    }
    public function sendMoneyToBusiness(array $attributes)
    {
        $business = auth('business')->user();
        $accountNumber = isset($attributes['account_number']) ? $attributes['account_number'] : null;
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $business->pin)) {
            if($business->business_number === $attributes['business_number']){
               throw new Exception("You can't send money to yourself");
           }
           if($business->sendMoneyToBusiness($attributes['amount'],$attributes['business_number'],$attributes['channel'],$accountNumber)){
               return;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    //$amount,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA",$toAccount = null,$fromAccount=null
    public function sendMoneyToBank(array $attributes)
    {
        $business = auth('business')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$business->pin))
        {
            if($business->sendMoneyToBank($attributes['amount'],$attributes['channel'],$attributes['account_number'],"AGOGA",$attributes['bank'])){
               return;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }

    public function sendMoneyToMobileMoney(array $attributes)
    {
        $business = auth('business')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$business->pin))
        {
            if($business->sendMoneyToMobileMoney($attributes['amount'],$attributes['channel'],$attributes['account_number'],"AGOGA",$attributes['mobile_money'])){
               return;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function payBill(array $attributes)
    {
        $business = auth('business')->user();
        $accountNumber = isset($attributes['account_number']) ? $attributes['account_number'] : null;
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $business->pin)) {
            if($business->business_number === $attributes['business_number']){
               throw new Exception("You can't pay bill to yourself");
           }
           if($business->payBill($attributes['amount'],$attributes['business_number'],$attributes['channel'],$accountNumber)){
               return;
           }
           throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function transactions()
    {
        return auth('business')->user()->transactions()->get();
    }
     public function search($filter)
    {
        return auth('business')->user()->transactions()->filter($filter)->get();
    }
    public function buyAirtime(array $attributes)
    {
        $business = auth('business')->user();
        $hasher = app('hash');
        if($hasher->check($attributes['pin'],$business->pin))
        {
            if($business->buyAirtime($attributes['amount'],$attributes['channel'],$attributes['mobile_number'],"AGOGA",$attributes['airtime_provider'])){
               return;
            }
            throw new Exception("Insufficient Balance");
        }
        throw new Exception("Invalid Pin ");
    }
    public function withdrawViaAgent(array $attributes)
    {

        $business = auth('business')->user();
        $accountNumber = isset($attributes['account_number']) ? $attributes['account_number'] : null;
        //Extract Pin checking to a custom validator or Helper
        $hasher = app('hash');
        if ($hasher->check($attributes['pin'], $business->pin)) {
           if($business->business_number === $attributes['business_number']){
               throw new Exception("You can't withdraw from yourself");
           }
           if($transaction = $business->withdrawViaAgent($attributes['amount'],$attributes['business_number'],$attributes['channel'],$accountNumber)){
               return $transaction;
           }else{
               throw new Exception("Insufficient Balance");
           }

        }
        throw new Exception("Invalid Pin ");
    }
    public function updatePin($attributes)
    {

         $business = $this->find(auth('business')->id());

         $hasher = app('hash');
        if ($hasher->check($attributes['old_pin'], $business->pin)) {
           $business->fill([
            'pin' => Hash::make($attributes['pin'])
           ]);
           $business->save();
           return;
        }
        throw new Exception("Old pin Incorrect");
    }
}
