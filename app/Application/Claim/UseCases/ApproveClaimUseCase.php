<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;

class ApproveClaimUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(int $claimId, int $approverId)
    {
        return $this->repo->approve($claimId, $approverId);
    }
}