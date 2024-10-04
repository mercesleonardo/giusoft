<?php

namespace App\Repositories;

use App\Models\{Database, Product};
use PDO;
use PDOStatement;

class ProductRepository
{
    protected ?PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    public function all(): array
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description, price FROM products');

        return $this->extracted($stmt);
    }

    public function find(int|string $id): ?Product
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description, price FROM products WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return new Product($result['name'], $result['description'], $result['price'], $result['id']);
    }

    public function findByName(string $name): array
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description, price FROM products WHERE name LIKE :name');
        $stmt->bindValue(':name', '%' . $name . '%');

        return $this->extracted($stmt);
    }

    public function save(Product $product): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (name, description, price) VALUES (:name, :description, :price)');

        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':price', $product->price);

        $stmt->execute();

        return $this->pdo->lastInsertId() > 0;
    }

    public function update(Product $product): bool
    {

        $stmt = $this->pdo->prepare('UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id');

        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':price', $product->price);
        $stmt->bindParam(':id', $product->id);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function delete(Product $product): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $product->id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function paginate($lastProductId = null, $limit = 10): array
    {
        $limit = (int)$limit;

        if ($lastProductId) {
            $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id > :lastProductId ORDER BY id ASC LIMIT :limit');
            $stmt->bindParam(':lastProductId', $lastProductId, PDO::PARAM_INT);
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY id ASC LIMIT :limit');
        }
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $this->extracted($stmt);
    }

    public function extracted(false|PDOStatement $stmt): array
    {
        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $products = [];

        foreach ($results as $result) {
            $product     = new Product($result['name'], $result['description'], $result['price']);
            $product->id = $result['id'];
            $products[]  = $product;
        }

        return $products;
    }
}
