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
     * @throws JsonException
     */
    public function index(): void
    {
        Response::json($this->productService->list());
    }

    /**
     * @throws JsonException
     */
    public function show($id): void
    {
        Response::json([$this->productService->find($id)]);
    }

    /**
     * @throws JsonException
     */
    public function search(): false|string
    {
        $name     = $_GET['name'] ?? '';
        $products = $this->productService->findByName($name);

        return json_encode($products, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws JsonException
     */
    public function store()
    {
        $data   = Request::body();
        $result = $this->productService->create($data);

        if (isset($result['error'])) {
            return Response::json(['error' => $result['error']], 400);
        }

        Response::json(['message' => 'Produto criado com sucesso'], 201);
    }

    /**
     * @throws JsonException
     */
    public function update($id)
    {
        $data       = Request::body();
        $data['id'] = $id;
        $result     = $this->productService->update($data);

        if (isset($result['error'])) {
            return Response::json(['error' => $result['error']], 400);
        }

        Response::json(['message' => 'Produto atualizado com sucesso']);
    }

    /**
     * @throws JsonException
     */
    public function remove($id)
    {
        $result = $this->productService->delete($id);

        if (isset($result['error'])) {
            return Response::json(['error' => $result['error']], $result['code']);
        }
        Response::json(['message' => 'Produto deletado com sucesso']);
    }
}
