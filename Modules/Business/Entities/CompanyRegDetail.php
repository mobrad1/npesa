<?php

namespace Modules\Business\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyRegDetail extends Model
{
    use HasFactory;

    protected $guarded = ['approved'];
    
    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\CompanyRegDetailFactory::new();
    }
}
