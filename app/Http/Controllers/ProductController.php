<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = Product::all();
        return response()->json($products);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $errors = $this->productService->validate($request);

        if(!empty($errors['message'])) {
            return response()->json(['message' => $errors['message']],400);
        }

        $product = new Product;
        $product->name = $request->input('name');
        $product->amount = $request->input('amount');
        $product->price = $request->input('price');
        $product->is_rentable = $request->input('is_rentable');
        $product->status = $request->input('status');
        $product->save();

        return response()->json(['message' => 'Product created successfully.']);
    }
}
