<?php

namespace Modules\Business\Entities;

use App\Models\BankAccount;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Business\Notification\BusinessVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Business\Contracts\HasApiKeys as ContractsHasApiKeys;
use Modules\Business\Traits\HasApiKeys;

class Business extends Authenticatable implements MustVerifyEmail, ContractsHasApiKeys
{
    use HasApiTokens, HasFactory, Notifiable, HasApiKeys;

    protected $guard = 'business';

    //protected $fillable = [];
    protected $guarded = [];
    
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
