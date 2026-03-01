<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Claim\Entities\Claim;
use App\Domain\Claim\Repositories\ClaimRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ClaimModel;
use Illuminate\Support\Str;

class ClaimRepository implements ClaimRepositoryInterface
{
    private function toEntity(ClaimModel $model): Claim
    {
        return new Claim(
            $model->id,
            $model->claim_number,
            $model->user_id,
            $model->title,
            $model->description,
            $model->amount,
            $model->status,
            $model->verified_by,
            $model->verified_at,
            $model->approved_by,
            $model->approved_at,
            $model->rejection_reason
        );
    }

    public function getAll(): array
    {
        return ClaimModel::latest()
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->toArray();
    }

    public function getByUserId(int $userId): array
    {
        return ClaimModel::where('user_id', $userId)
            ->latest()
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->toArray();
    }

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
