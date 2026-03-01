<?php

namespace App\Domain\Claim\Entities;

class Claim
{
    public function __construct(
        public ?int $id,
        public string $claimNumber,
        public int $userId,
        public string $title,
        public string $description,
        public float $amount,
        public string $status,
        public ?int $verifiedBy,
        public ?date $verifiedAt,
        public ?int $approvedBy,
        public ?date $approvedAt,
        public ?string $rejectionReason,
    ) {}
}