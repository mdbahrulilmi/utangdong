<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = [
        'loan_id',
        'lender_id',
        'interest_rate',
        'amount',
        'repayment_amount',
    ];

    // Relationship
    public function offer()
    {
        return $this->hasOne(Offer::class, 'loan_id');
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

}
