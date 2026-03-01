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
            $model->user_id,
            $model->policy_number,
            $model->claim_amount,
            $model->description,
            $model->status,
            $model->verified_by,
            $model->approved_by,
            $model->rejection_reason,
            $model->created_at
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
        $model = ClaimModel::create($data);

        return $this->toEntity($model);
    }

    public function verify(int $id, int $verifierId)
    {
        $model = $this->find($id);

        $model->update([
            'status' => 'verified',
            'verified_by' => $verifierId,
            'verified_at' => now(),
        ]);

        return $this->toEntity($model);
    }

    public function approve(int $id, int $approverId)
    {
        $model = $this->find($id);

        $model->update([
            'status' => 'approved',
            'approved_by' => $approverId,
            'approved_at' => now(),
        ]);

        return $this->toEntity($model);
    }

    public function reject(int $id, int $approverId, string $reason)
    {
        $model = $this->find($id);

        $model->update([
            'status' => 'rejected',
            'approved_by' => $approverId,
            'approved_at' => now(),
            'rejection_reason' => $reason
        ]);

        return $this->toEntity($model);
    }
}
