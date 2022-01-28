<?php

namespace Modules\Business\Entities;

use App\Enums\BusinessNumber;
use App\Models\BankAccount;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Business\Notification\BusinessVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Business extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    //protected $fillable = [];
    protected $guarded = [];

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

        return Transaction::where("transactional_to_type",get_class($this))
            ->orWhere("transactional_from_type",get_class($this))
            ->where("transactional_from_id",$this->id)
            ->orWhere("transactional_to_id",$this->id);
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

    /**
     * Business Reg Details
     *
     * @return Collection
     */
    public function companyReg()
    {
        return $this->hasOne(CompanyRegDetail::class);
    }


    /**
     * Gets the businesses banking information
     *
     * @return void
     */
    public function account()
    {
        return $this->morphOne(BankAccount::class, 'payable');
    }
}
