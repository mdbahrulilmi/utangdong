<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lender extends Model
{
    protected $fillable = [
        'user_id',
        'company',
        'balance',
    ];

    // Relationship
    public function offers()
    {
        return $this->hasMany(Offer::class, 'lender_id');
    }

    public function lender()
    {
        return $this->belongsTo(Lender::class, 'lender_id');
    }

}
