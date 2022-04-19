<?php

namespace Modules\Business\Entities;

use App\Enums\BusinessNumber;
use App\Models\BankAccount;
use App\Models\Transaction;
use App\Notifications\CreditBusinessWithSms;
use App\Traits\Filterable;
use App\Traits\RecordTransaction;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Business\Notification\BusinessVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Customer\Entities\Customer;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Business extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, RecordTransaction,LogsActivity,Filterable;

    //protected $fillable = [];
    protected $guarded = [];
    protected $hidden = [
        'pin'
    ];
    protected $casts = [
        'balance' => 'real'
    ];
    protected  $logName = 'Business';

    public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
             ->setDescriptionForEvent(fn(string $eventName) => "{$this->logName} has been {$eventName}")
             ->useLogName($this->logName)
             ->logAll();
    }
    protected static function booted()
    {
        static::created(function ($business) {
            $business->business_number = BusinessNumber::FORMAT + $business->id;
            $business->save();
        });
    }

    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\BusinessFactory::new();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new BusinessVerifyEmail);
    }

    public function transactions()
    {
        return Transaction::where("transactional_to_type", get_class($this))
            ->orWhere("transactional_from_type", get_class($this))
            ->where("transactional_from_id", $this->id)
            ->orWhere("transactional_to_id", $this->id);
    }

    /**
     * The owner profile for this business has been completed
     *
     * @return bool
     */
    public function hasCompletedOwnerProfile()
    {
        return $this->is_completed_owner_profile;
    }






    public function sendMoneyToCustomer($amount, $phone, $channel)
    {
        $recipient = Customer::where("phone", $phone)->first();
        if ($this->balance > $amount) {
            $recipient->balance += $amount;
            $this->balance -= $amount;
            $recipient->save();
            $this->save();
            $this->recordInternal($amount, $recipient->phone, $channel, 1, $this->phone, $recipient, $this);
//            $recipient->notify(new CreditBusinessWithSms());
            return true;
        }
        return false;
    }
    public function sendMoneyToBusiness($amount,$business_number,$channel,$account_number)
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


    public function sendMoneyToBank($amount, $channel, $account_number = null, $transaction_from_group = "AGOGA", $transaction_to_group = "AGOGA")
    {
        if ($this->balance > $amount) {
            $this->balance -= $amount;
            $this->save();
            $this->recordExternal(
                $amount, $channel, 1, $this->phone, $account_number, null, $this,
                $transaction_from_group, $transaction_to_group);
            return true;
        }
        return false;
    }

    public function sendMoneyToMobileMoney($amount, $channel, $account_number = null, $transaction_from_group = "AGOGA", $transaction_to_group = "AGOGA")
    {
        if ($this->balance > $amount) {
            $this->balance -= $amount;
            $this->save();
            $this->recordExternal(
                $amount, $channel, 1, $this->phone, $account_number, null, $this,
                $transaction_from_group, $transaction_to_group);
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
}
