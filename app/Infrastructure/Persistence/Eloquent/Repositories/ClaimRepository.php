<?php

namespace App\Infrastructure\Persistence\Eloquent\Repositories;

use App\Domain\Claim\Entities\Claim;
use App\Domain\Claim\Repositories\ClaimRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\Models\ClaimModel;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ClaimRepository implements ClaimRepositoryInterface
{
    private function toEntity(ClaimModel $model): Claim
    {
        return new Claim(
            $model->id,
            $model->claim_number,
            $model->user_id,
            $model->user?->name,
            $model->title,
            $model->description,
            $model->amount,
            $model->status,
            $model->verified_by,
            $model->verifier?->name,
            $model->verified_at,
            $model->approved_by,
            $model->approver?->name,
            $model->approved_at,
            $model->rejection_reason,
            $model->created_at,
            $model->updated_at
        );
    }

    private function paginateQuery(Builder $query, int $page, int $limit): array
    {
        $total = $query->count();

        $records = $query
            ->offset(($page - 1) * $limit)
            ->limit($limit)
            ->get()
            ->map(fn($model) => $this->toEntity($model))
            ->toArray();

        return [
            "data" => $records,
            "total" => $total
        ];
    }

    public function getAll(int $page, int $limit): array
    {
        $user = Auth::user();
        $query = ClaimModel::with('user', 'verifier', 'approver')->latest();
        if ($user->role === 'verifier') {
            $query->where('status', 'submitted');
        } else {
            $query->where('status', 'verified');
        }

        return $this->paginateQuery($query, $page, $limit);
    }

    public function getByUserId(int $userId, int $page, int $limit): array
    {
        $query = ClaimModel::with('user', 'verifier', 'approver')->where('user_id', $userId)->latest();

        return $this->paginateQuery($query, $page, $limit);
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
