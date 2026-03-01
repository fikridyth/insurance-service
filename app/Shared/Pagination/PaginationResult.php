<?php

namespace App\Shared\Pagination;

use App\Shared\Responses\Response;

class PaginationResult
{
    public function __construct(
        public array $records,
        public int $page,
        public int $limit,
        public int $totalRecord
    ) {}

    public function getPagination(): array
    {
        return Response::pagination(
            $this->page,
            $this->limit,
            $this->totalRecord
        );
    }

    public function getRecords(): array
    {
        return $this->records;
    }
}