<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    protected $fillable = [
        'loan_id',
        'amount_paid',
        'paid_at',
    ];
    
    //Relationship
    public function repayments()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
