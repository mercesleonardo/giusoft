<?php

namespace App\Repositories;

use App\Models\{Database, Product};
use PDO;
use PDOStatement;

class ProductRepository
{
    protected ?PDO $pdo;

    /**
     * Constructs a new ProductRepository instance.
     */
    public function __construct()
    {
        $this->pdo = Database::connect();
    }

    /**
     * Retrieves all products from the database.
     *
     * @return array An array of Product objects.
     */
    public function all(): array
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description, price FROM products');

        return $this->extracted($stmt);
    }

    /**
     * Finds a product by its ID.
     *
     * @param int|string $id The ID of the product to find.
     *
     * @return Product|null The found product or null if not found.
     */
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

    /**
     * Finds products by their name.
     *
     * @param string $name The name of the products to find.
     *
     * @return array An array of Product objects.
     */
    public function findByName(string $name): array
    {
        $stmt = $this->pdo->prepare('SELECT id, name, description, price FROM products WHERE name LIKE :name');
        $stmt->bindValue(':name', '%' . $name . '%');

        return $this->extracted($stmt);
    }

    /**
     * Saves a new product to the database.
     *
     * @param Product $product The product to save.
     *
     * @return bool True if the product was saved successfully, false otherwise.
     */
    public function save(Product $product): bool
    {
        $stmt = $this->pdo->prepare('INSERT INTO products (name, description, price) VALUES (:name, :description, :price)');

        $stmt->bindParam(':name', $product->name);
        $stmt->bindParam(':description', $product->description);
        $stmt->bindParam(':price', $product->price);

        $stmt->execute();

        return $this->pdo->lastInsertId() > 0;
    }

    /**
     * Updates an existing product in the database.
     *
     * @param Product $product The product to update.
     *
     * @return bool True if the product was updated successfully, false otherwise.
     */
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

    /**
     * Deletes a product from the database.
     *
     * @param Product $product The product to delete.
     *
     * @return bool True if the product was deleted successfully, false otherwise.
     */
    public function delete(Product $product): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM products WHERE id = :id');
        $stmt->bindParam(':id', $product->id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    /**
     * Retrieves a paginated list of products.
     *
     * @param int|null $lastProductId The ID of the last product retrieved in the previous page.
     * @param int $limit         The maximum number of products to retrieve per page.
     *
     * @return array An array of Product objects.
     */
    public function paginate(int $lastProductId = null, int $limit = 10): array
    {
        $limit = (int)$limit;

        if ($lastProductId) {
            $stmt = $this->pdo->prepare('SELECT * FROM products WHERE id > :lastProductId ORDER BY id ASC LIMIT :limit');
            $stmt->bindParam(':lastProductId', $lastProductId, PDO::PARAM_INT);
        } else {
            $stmt = $this->pdo->prepare('SELECT * FROM products ORDER BY id ASC LIMIT :limit');
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

        $stmt->execute();

        return $this->extracted($stmt);
    }

    /**
     * Extracts product data from a PDOStatement and returns an array of Product objects.
     *
     * @param false|PDOStatement $stmt The PDOStatement to extract data from.
     *
     * @return array An array of Product objects.
     */
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
