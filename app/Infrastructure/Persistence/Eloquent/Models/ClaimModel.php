<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimModel extends Model
{
    protected $table = 'claims';

    protected $fillable = [
        'claim_number',
        'user_id',
        'title',
        'description',
        'amount',
        'status',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'rejection_reason'
    ];
}