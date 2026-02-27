<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;

class CreateClaimUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(array $data)
    {
        return $this->repo->create($data);
    }
}