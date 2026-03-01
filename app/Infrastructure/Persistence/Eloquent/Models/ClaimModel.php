<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'verified_by', 'id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'approved_by', 'id');
    }
}