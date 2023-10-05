<?php

namespace App\DTO;

readonly class PostData
{
    public function __construct(
        public int $userId,
        public string $title,
        public string $body,
        public bool   $isActive,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            auth()->id(),
            $data['title'],
            $data['body'],
            $data['is_active'] ?? false
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => auth()->id(),
            'title' => $this->title,
            'body' => $this->body,
            'is_active' => $this->isActive,
        ];
    }
}
