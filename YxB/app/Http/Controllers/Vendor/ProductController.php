<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')
            ->where('vendor_id', $this->vendorId())
            ->latest()
            ->get();

        return view('vendor.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('id')->get();

        return view('vendor.products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        Product::create([
            'vendor_id' => $this->vendorId(),
            ...$this->validatedData($request),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        return redirect()->route('products.edit', $product);
    }

    public function edit(string $id): View
    {
        $product = $this->findVendorProduct($id);
        $categories = Category::orderBy('id')->get();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        $product->update($this->validatedData($request));

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    private function findVendorProduct(string $id): Product
    {
        return Product::where('vendor_id', $this->vendorId())->findOrFail($id);
    }

    private function vendorId(): int
    {
        return (int) auth()->user()->vendorProfile->getKey();
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'technical_specs' => ['nullable', 'string'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'availability_status' => ['required', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:255'],
            'product_type' => ['required', 'string', 'max:255'],
        ]);
    }
}
