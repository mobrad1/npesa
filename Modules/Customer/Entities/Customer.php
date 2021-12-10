<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory,HasApiTokens;

    protected $fillable = ['first_name','last_name','middle_name','pin','phone_number',''];

    protected static function newFactory()
    {
        return \Modules\Customer\Database\factories\CustomerFactory::new();
    }
}
