<?php

namespace App\Domain\Claim\Repositories;

interface ClaimRepositoryInterface
{
    public function getAll(int $page, int $limit): array;
    public function getByUserId(int $userId, int $page, int $limit): array;
    public function create(array $data);
    public function find(int $id);
    public function verify(int $id, int $verifierId);
    public function approve(int $id, int $approverId);
    public function reject(int $id, int $approverId, string $reason);
}