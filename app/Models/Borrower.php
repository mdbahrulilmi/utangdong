<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $fillable = [
        'user_id',
        'credit_score'
    ];

    public function borrower()
    {
        return $this->hasOne(User::class, 'user_id');
    }
}
