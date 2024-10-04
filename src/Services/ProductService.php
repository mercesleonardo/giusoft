<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Validator\Validator;
use Exception;
use RuntimeException;

class ProductService
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function list(): array
    {
        return $this->productRepository->all();
    }

    public function find(int|string $id): Product|array|null
    {
        try {
            return $this->productRepository->find($id);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function findByName(string $name): array
    {
        try {
            return $this->productRepository->findByName($name);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function create(array $data): array|string
    {
        try {
            $fields = Validator::validate([
                'name'        => $data['name'] ?? '',
                'description' => $data['description'] ?? '',
                'price'       => $data['price'] ?? '',
            ]);

            $product = Product::fromArray($fields);
            $this->productRepository->save($product);

            return 'Produto criado com sucesso!';
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

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
                return ['error' => 'Desculpa, o produto não pode ser atualizado.'];
            }

            return 'Produto atualizado com sucesso!';
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function delete(int|string $id): bool|array
    {
        try {
            $product = $this->productRepository->find($id);

            if (!$product) {
                throw new RuntimeException('Produto não encontrado.', 404);
            }

            return $this->productRepository->delete($product);
        } catch (Exception $e) {
            return [
                'error' => $e->getMessage(),
                'code'  => $e->getCode(),
            ];
        }
    }
}
