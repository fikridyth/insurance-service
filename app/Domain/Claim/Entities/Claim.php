<?php

namespace App\Domain\Claim\Entities;

class Claim
{
    public function __construct(
        public ?int $id,
        public int $userId,
        public string $title,
        public string $description,
        public float $amount,
        public string $status,
    ) {}
}