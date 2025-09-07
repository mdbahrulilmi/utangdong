<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'grade',
        'min_score',
        'max_score',
        'interest_rate',
        'late_fee_rate',
        'max_tenor_months',
        'max_loan_amount',
    ];
}
