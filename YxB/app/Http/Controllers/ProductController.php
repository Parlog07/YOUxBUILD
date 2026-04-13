<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['category', 'vendor.user'])->latest();

        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();

        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $id): View
    {
        $product = Product::with(['category', 'vendor.user'])->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
