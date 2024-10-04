<?php

namespace App\Models;

use InvalidArgumentException;

class Product
{
    public ?int $id;

    public string $name;

    public string $description;

    public float $price;

    /**
 * Constructs a new Product object.
 *
 * @param string $name        The name of the product.
 * @param string $description The description of the product.
 * @param float  $price       The price of the product.
 * @param int|null $id        The unique identifier of the product.
 */
    public function __construct(string $name, string $description, float $price, ?int $id = null)
    {
        $this->name        = $name;
        $this->description = $description;
        $this->price       = $price;
        $this->id          = $id;
    }

    /**
 * Creates a new Product object from an associative array.
 *
 * @param array $data An associative array containing product data.
 *
 * @return self A new Product object.
 *
 * @throws InvalidArgumentException If the required data is missing in the array.
 */
    public static function fromArray(array $data): self
    {
        if (!isset($data['name'], $data['description'], $data['price'])) {
            throw new InvalidArgumentException('Missing required data in the array.');
        }

        return new self(
            $data['name'] ?? '',
            $data['description'] ?? '',
            $data['price'] ?? 0.0,
            $data['id'] ?? null
        );
    }
}
