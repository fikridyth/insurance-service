<?php

namespace App\Domain\Claim\Entities;

class Claim
{
    public function __construct(
        public ?int $Id,
        public string $ClaimNumber,
        public int $UserId,
        public string $Title,
        public string $Description,
        public float $Amount,
        public string $Status,
        public ?int $VerifiedBy,
        public ?date $VerifiedAt,
        public ?int $ApprovedBy,
        public ?date $ApprovedAt,
        public ?string $RejectionReason,
    ) {}
}