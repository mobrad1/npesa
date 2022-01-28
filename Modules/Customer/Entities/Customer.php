<?php

namespace Modules\Customer\Entities;

use App\Enums\TransactionCategories;
use App\Models\Transaction;
use App\Traits\RecordTransaction;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Modules\Business\Entities\Business;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,HasApiTokens,HasApiTokens,RecordTransaction;

    protected $fillable = ['first_name','last_name','middle_name','pin',
                            'phone','marital_status','date_of_birth',
                            'gender','profile_picture','signature','state','area','city',
                        ];

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\CustomerFactory::new();
    }
    public function transactions()
    {

        return Transaction::where("transactional_to_type",get_class($this))
            ->orWhere("transactional_from_type",get_class($this))
            ->where("transactional_from_id",$this->id)
            ->orWhere("transactional_to_id",$this->id);
    }

    public function hasVerifiedEmail()
    {
        // TODO: Implement hasVerifiedEmail() method.
    }

    public function markEmailAsVerified()
    {
        // TODO: Implement markEmailAsVerified() method.
    }

    public function sendEmailVerificationNotification()
    {
        // TODO: Implement sendEmailVerificationNotification() method.
    }

    public function getEmailForVerification()
    {
        // TODO: Implement getEmailForVerification() method.
    }

    public function sendMoney($amount,$phone,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA")
    {
        $recipient = Customer::where("phone",$phone)->first();
        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"internal",TransactionCategories::SEND_MONEY,
                $groupFromName,$groupToName,$recipient->phone,$this->phone,$recipient,$this);
            return true;
        }
        return false;
    }
    public function sendMoneyToBank($amount,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA",$toAccount = null,$fromAccount=null)
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"external",TransactionCategories::SEND_MONEY,
                $groupFromName,$groupToName,$toAccount,$this->phone,null,$this);
            return true;
        }
        return false;
    }
    public function sendMoneyToMobileMoney($amount,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA",$toAccount = null,$fromAccount=null)
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"external",TransactionCategories::SEND_MONEY,
                $groupFromName,$groupToName,$toAccount,$this->phone,null,$this);
            return true;
        }
        return false;
    }
    public function buyAirtime($amount,$channel,$groupFromName ="AGOGA",$groupToName = "AGOGA",$toAccount = null,$fromAccount=null)
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"internal",TransactionCategories::AIRTIME,
                $groupFromName,$groupToName,$toAccount,$this->phone,null,$this);
            return true;
        }
        return false;
    }
    public function payBill($amount,$business_number,$channel,$toAccountNumber,$groupFromName ="AGOGA",$groupToName = "AGOGA")
    {
        //
        $recipient = Business::where("business_number",$business_number)->first();
        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"internal",TransactionCategories::PAY_BILLS,
                $groupFromName,$groupToName,$toAccountNumber,$this->phone,$recipient,$this);
            return true;
        }
        return false;
    }
    public function depositWithATM()
    {

    }
    public function depositViaAgent()
    {

    }
    public function depositViaBank()
    {

    }
    public function withdrawViaAgent($amount,$business_number,$channel,$toAccountNumber,$groupFromName ="AGOGA",$groupToName = "AGOGA")
    {
        $recipient = Business::where("business_number",$business_number)->first();
        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordReciepient(
                $amount,$channel,"internal",TransactionCategories::WITHDRAWALS,
                $groupFromName,$groupToName,$toAccountNumber,$this->phone,$recipient,$this);
            return true;
        }
        return false;
    }
    public function withdrawViaATM()
    {

    }

}
