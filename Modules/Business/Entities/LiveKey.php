<?php

namespace Modules\Business\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveKey extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Business\Database\factories\LiveKeyFactory::new();
    }
}
