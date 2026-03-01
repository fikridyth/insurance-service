<?php

namespace App\Domain\Claim\Entities;

class Claim
{
    public function __construct(
        public ?int $Id,
        public string $ClaimNumber,
        public int $UserId,
        public ?string $UserName,
        public string $Title,
        public string $Description,
        public float $Amount,
        public string $Status,
        public ?int $VerifiedBy,
        public ?string $VerifiedName,
        public ?string $VerifiedAt,
        public ?int $ApprovedBy,
        public ?string $ApprovedName,
        public ?string $ApprovedAt,
        public ?string $RejectionReason,
        public string $CreatedAt,
        public string $UpdatedAt,
    ) {}
}