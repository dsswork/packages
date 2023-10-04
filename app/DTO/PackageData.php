<?php

namespace App\DTO;

readonly class PackageData
{
    public function __construct(
        public string $name,
        public float  $price,
        public int    $publications,
        public bool   $isActive
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['price'],
            $data['publications'],
            $data['is_active']
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'price' => $this->price,
            'publications' => $this->publications,
            'is_active' => $this->isActive,
        ];
    }
}
