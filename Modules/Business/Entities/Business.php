<?php

namespace Modules\Business\Entities;

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
}
