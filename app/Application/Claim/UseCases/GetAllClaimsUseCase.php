<?php

namespace App\Application\Claim\UseCases;

use App\Domain\Claim\Repositories\ClaimRepositoryInterface;
use App\Shared\Pagination\PaginationResult;

class GetAllClaimsUseCase
{
    public function __construct(
        private ClaimRepositoryInterface $repo
    ) {}

    public function execute(int $page = 1, int $limit = 10): PaginationResult
    {
        $result = $this->repo->getAll($page, $limit);

        return new PaginationResult(
            records: $result["data"],
            page: $page,
            limit: $limit,
            totalRecord: $result["total"]
        );
    }
}