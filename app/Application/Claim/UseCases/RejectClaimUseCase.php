<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;

class RejectClaimUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(int $claimId, int $approverId, string $reason)
    {
        return $this->repo->reject($claimId, $approverId, $reason);
    }
}