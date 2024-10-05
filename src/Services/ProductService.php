<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Validator\Validator;
use Exception;

class ProductService
{
    private ProductRepository $productRepository;

    /**
     * ProductService constructor.
     *
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * List all products.
     *
     * @return array
     */
    public function list(): array
    {
        return $this->productRepository->all();
    }

    /**
     * Paginate products.
     *
     * @param int|null $lastProductId The ID of the last product in the previous page.
     * @param int $limit         The number of products per page.
     *
     * @return array
     */
    public function paginate(int $lastProductId = null, int $limit = 10): array
    {
        try {
            return $this->productRepository->paginate($lastProductId, $limit);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Find a product by ID.
     *
     * @param int|string $id The ID of the product.
     *
     * @return Product|array|null
     */
    public function find(int|string $id): Product|array|null
    {
        try {
            return $this->productRepository->find($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Find products by name.
     *
     * @param string $name The name of the product.
     *
     * @return array
     */
    public function findByName(string $name): array
    {
        try {
            return $this->productRepository->findByName($name);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Create a new product.
     *
     * @param array $data The data for the new product.
     *
     * @return array
     */
    public function create(array $data): array
    {
        try {
            $fields = Validator::validate([
                'name'        => $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'price'       => $data['price'] ?? '',
            ]);

            $product = Product::fromArray($fields);
            $this->productRepository->save($product);

            return ['success' => true, 'message' => 'Produto criado com sucesso'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Update an existing product.
     *
     * @param array $data The updated data for the product.
     *
     * @return array|string
     */
    public function update(array $data): array|string
    {
        try {
            $fields = Validator::validate([
                'id'          => $data['id'] ?? null,
                'name'        => $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'price'       => $data['price'] ?? '',
            ]);

            $product = Product::fromArray($fields);
            $updated = $this->productRepository->update($product);

            if (!$updated) {
                return ['success' => false, 'error' => 'Desculpa, o produto não pode ser atualizado.'];
            }

            return ['success' => true, 'message' => 'Produto atualizado com sucesso'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Delete a product by ID.
     *
     * @param int|string $id The ID of the product.
     *
     * @return bool|array
     */
    public function delete(int|string $id): bool|array
    {
        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                return ['success' => false, 'error' => 'Produto não encontrado', 'code' => 404];
            }

            $this->productRepository->delete($product);

            return ['success' => true, 'message' => 'Produto deletado com sucesso'];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $e->getMessage(), 'code' => $e->getCode()];
        }
    }
}
