<?php

namespace App\Controllers;

use App\Http\{Request, Response};
use App\Services\ProductService;
use JsonException;

class ProductController
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Lists all products.
     *
     * @throws JsonException
     */
    public function index(): void
    {
        Response::json($this->productService->list());
    }

    /**
     * Paginates the products.
     *
     * @throws JsonException
     */
    public function paginate(): void
    {
        $lastProductId = $_GET['lastProductId'] ?? null;
        $limit         = $_GET['limit'] ?? 10;

        $products = $this->productService->paginate($lastProductId, $limit);

        if (isset($products['error'])) {
            Response::json(['error' => $products['error']], 400);

            return;
        }

        Response::json($products);
    }

    /**
     * Shows a specific product by ID.
     *
     * @param int $id The ID of the product to show.
     * @throws JsonException
     */
    public function show(int $id): void
    {
        Response::json([$this->productService->find($id)]);
    }

    /**
     * Searches for products by name.
     *
     * @throws JsonException
     * @return false|string Returns false if the request is successful, otherwise returns a JSON response with an error message.
     */
    public function search(): false|string
    {
        $name     = $_GET['name'] ?? '';
        $products = $this->productService->findByName($name);

        if (isset($products['error'])) {
            return Response::json(['error' => $products['error']], 404);
        }

        Response::json($products);

        return false;
    }

    /**
     * Stores a new product.
     *
     * @throws JsonException
     */
    public function store()
    {
        $data   = Request::body();
        $result = $this->productService->create($data);

        if (!$result['success']) {
            return Response::json(['error' => $result['error']], 400);
        }

        Response::json(['message' => $result['message']], 201);
    }

    /**
     * Updates an existing product.
     *
     * @param int $id The ID of the product to update.
     * @throws JsonException
     */
    public function update(int $id)
    {
        $data       = Request::body();
        $data['id'] = $id;
        $result     = $this->productService->update($data);

        if (!$result['success']) {
            return Response::json(['error' => $result['error']], 400);
        }

        Response::json(['message' => $result['message']]);
    }

    /**
     * Deletes a product by ID.
     *
     * @param int $id The ID of the product to delete.
     * @throws JsonException
     */
    public function remove(int $id)
    {
        $result = $this->productService->delete($id);

        if (!$result['success']) {
            return Response::json(['error' => $result['error']], $result['code']);
        }

        Response::json(['message' => $result['message']]);
    }
}
