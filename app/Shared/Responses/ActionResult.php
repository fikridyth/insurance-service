<?php

namespace App\Shared\Responses;

class ActionResult
{
    public function __construct(
        public ?bool $status,
        public ?string $title,
        public ?string $description
    ) {}

    public static function success(
        string $title = "Success",
        string $description = ""
    ): self {
        return new self(
            true,
            $title,
            $description
        );
    }

    public static function error(
        string $title = "Error",
        string $description = ""
    ): self {
        return new self(
            false,
            $title,
            $description
        );
    }

    public static function exception(\Throwable $e): self
    {
        return new self(
            false,
            $e->getMessage(),
            "Error Server"
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