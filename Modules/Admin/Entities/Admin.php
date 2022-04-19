<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Model
{
    use  HasApiTokens, HasFactory, Notifiable,LogsActivity,HasRoles;

    protected $guarded = [];
    protected $hidden = [
        'pin'
    ];
     protected $logName = "Admin";
     public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
             ->setDescriptionForEvent(fn(string $eventName) => "{$this->logName} has been {$eventName}")
             ->useLogName($this->logName)
             ->logAll();
    }
    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\AdminFactory::new();
    }
}
