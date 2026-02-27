<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ClaimModel;
use Illuminate\Support\Str;

class ClaimRepository implements ClaimRepositoryInterface
{
    public function create(array $data)
    {
        $data['claim_number'] = 'CLM-' . Str::uuid();

        return ClaimModel::create($data);
    }

    public function find(int $id)
    {
        return ClaimModel::findOrFail($id);
    }

    public function verify(int $id, int $verifierId)
    {
        $claim = $this->find($id);

        $claim->update([
            'status' => 'verified',
            'verified_by' => $verifierId,
            'verified_at' => now(),
        ]);

        return $claim;
    }

    public function approve(int $id, int $approverId)
    {
        $claim = $this->find($id);

        $claim->update([
            'status' => 'approved',
            'approved_by' => $approverId,
            'approved_at' => now(),
        ]);

        return $claim;
    }

    public function reject(int $id, int $approverId, string $reason)
    {
        $claim = $this->find($id);

        $claim->update([
            'status' => 'rejected',
            'approved_by' => $approverId,
            'approved_at' => now(),
            'rejection_reason' => $reason
        ]);

        return $claim;
    }
}
