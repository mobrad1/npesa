<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    
    /**
     * Get the parent account owner
     *
     * @return void
     */
    public function payabale()
    {
        return $this->morphTo();
    }
}
