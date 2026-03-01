<?php

namespace App\Shared\Responses;

class ActionResult
{
    public function __construct(
        public ?string $status,
        public ?string $title,
        public ?array $description = []
    ) {}

    public static function success(
        string $title = "Success",
        array $description = []
    ): self {
        return new self(
            "Success",
            $title,
            $description
        );
    }

    public static function error(
        string $title = "Error",
        array $description = []
    ): self {
        return new self(
            "Error",
            $title,
            $description
        );
    }

    public static function exception(\Throwable $e): self
    {
        return new self(
            "Error",
            $e->getMessage(),
            []
        );
    }

    public function toArray(): array
    {
        return [
            "Status" => $this->status,
            "Title" => $this->title,
            "Description" => $this->description
        ];
    }
}