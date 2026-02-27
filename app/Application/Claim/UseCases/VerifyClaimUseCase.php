<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;

class VerifyClaimUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(int $claimId, int $verifierId)
    {
        return $this->repo->verify($claimId, $verifierId);
    }
}