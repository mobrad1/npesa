<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use HasFactory,Filterable,LogsActivity;
    protected $guarded = [];
     protected $logName = "Transactions";
     public function getActivitylogOptions() : LogOptions
    {
        return LogOptions::defaults()
             ->setDescriptionForEvent(fn(string $eventName) => "{$this->logName} has been {$eventName}")
             ->useLogName($this->logName)
             ->logAll();
    }
    public function sender()
    {
        return ($this->transactional_from_type)::find($this->transactional_from_id);
    }
    public function receiver()
    {
        return ($this->transactional_to_type)::find($this->transactional_to_id);
    }
}
