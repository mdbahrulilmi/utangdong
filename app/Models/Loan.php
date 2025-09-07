<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Repayment;

class Loan extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'tenor',
        'purpose',
        'interest_rate',
        'total_repayment',
        'status',
        'disbursed_amount',
        'disbursed_at',
    ];


    // Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function repayments()
    {
        return $this->hasMany(Repayment::class, 'loan_id');
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'loan_id');
    }
}
