<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;

class GetAllClaimsByUserIdUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(int $userId): array
    {
        return $this->repo->getByUserId($userId);
    }
}