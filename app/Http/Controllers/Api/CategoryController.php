<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Services\CategoryService;


class CategoryController extends Controller
{


    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return $this->categoryService->getAllCategories();
    }



    public function store(CreateRequest $request)
    {
        return $this->categoryService->createCategory($request);
    }





    public function update(UpdateRequest $request, $id)
    {
        return $this->categoryService->updateCategory($request, $id);
    }


    public function destroy($id)
    {
           return $this->categoryService->deleteCategory($id);
    }
}
