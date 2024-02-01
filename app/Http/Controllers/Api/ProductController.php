<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Services\ProductService;
use http\Client\Request;


class ProductController extends Controller
{

    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function search(Request $request)
    {
       return $this->productService->searchProducts($request);
    }

    public function index()
    {
        return $this->productService->getAllProducts();
    }


    public function store(CreateRequest $request)
    {
        return $this->productService->createProduct($request);
    }


    public function show($id)
    {
        return $this->productService->getSingleProduct($id);
    }


    public function update(UpdateRequest $request, $id)
    {
        return $this->productService->updateProduct($request, $id);
    }


    public function destroy($id)
    {
        return $this->productService->deleteProduct($id);
    }
}
