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
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasFactory,HasApiTokens,RecordTransaction,LogsActivity;

    protected $fillable = ['first_name','last_name','middle_name','pin',
                            'phone','marital_status','date_of_birth',
                            'gender','profile_picture','signature','state','area','city','banned'
                        ];
     protected $hidden = [
       'pin'
    ];
     protected $logName = "Customer";
     public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
             ->setDescriptionForEvent(fn(string $eventName) => "{$this->logName} has been {$eventName}")
             ->useLogName($this->logName)
             ->logAll();
    }
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
    public function getMobileForPasswordReset()
    {
        return $this->phone;
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

    public function sendMoney($amount,$phone,$channel)
    {
        $recipient = Customer::where("phone",$phone)->first();
        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordInternal($amount,$recipient->phone,$channel,1,$this->phone,$recipient,$this);
            return true;
        }
        return false;
    }
    public function sendMoneyToBank($amount,$channel,$account_number = null,$transaction_from_group = "AGOGA",$transaction_to_group = "AGOGA")
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordExternal(
                $amount,$channel,1,$this->phone,$account_number,null,$this,
                $transaction_from_group,$transaction_to_group);
            return true;
        }
        return false;
    }
    public function sendMoneyToMobileMoney($amount,$channel,$account_number = null,$transaction_from_group = "AGOGA",$transaction_to_group = "AGOGA")
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordExternal(
                $amount,$channel,1,$this->phone,$account_number,null,$this,
                $transaction_from_group,$transaction_to_group);
            return true;
        }
        return false;
    }
    public function buyAirtime($amount,$channel,$account_number = null,$transaction_from_group = "AGOGA",$transaction_to_group = "AGOGA")
    {
        if($this->balance > $amount){
            $this->balance -= $amount;
            $this->save();
            $this->recordExternal($amount,$channel,1,$this->phone,$account_number,null,$this,$transaction_from_group = "AGOGA",$transaction_to_group);
            return true;
        }
        return false;
    }
    public function payBill($amount,$business_number,$channel,$account_number)
    {
        //
        $recipient = Business::where("business_number",$business_number)->first();
        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordInternal($amount,$recipient->business_number,$channel,1,$this->phone,$recipient,$this,$account_number);
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
    public function withdrawViaAgent($amount,$business_number,$channel,$account_number)
    {
        $recipient = Business::where("business_number",$business_number)->first();

        if($this->balance > $amount){
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordInternal($amount,$recipient->business_number,$channel,1,$this->phone,$recipient,$this,$account_number);
            return true;
        }
        return false;
    }
    public function withdrawViaATM()
    {

    }
    public function ban()
    {
        return $this->update([
            'banned' => !$this->banned
        ]);
    }

}
