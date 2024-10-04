<?php

namespace App\Models;

class Product
{
    public ?int $id;

    public string $name;

    public string $description;

    public float $price;

    public function __construct(string $name, string $description, float $price, ?int $id = null)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->price       = $price;
        $this->id          = $id;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['price'] ?? 0.0,
            $data['id'] ?? null
        );
    }
}
