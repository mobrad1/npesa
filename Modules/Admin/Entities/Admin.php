<?php

namespace Modules\Admin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Model
{
    use  HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];
    protected $hidden = [
        'pin'
    ];

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\AdminFactory::new();
    }
}
