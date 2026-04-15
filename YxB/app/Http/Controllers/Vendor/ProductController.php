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
    /**
     * List only the authenticated vendor's products.
     */
    public function index(): View
    {
        $products = Product::with('category')
            ->where('vendor_id', $this->vendorId())
            ->latest()
            ->get();

        return view('vendor.products.index', compact('products'));
    }

    /**
     * Show the product creation form.
     */
    public function create(): View
    {
        $categories = Category::orderBy('id')->get();

        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a product for the authenticated vendor only.
     */
    public function store(Request $request): RedirectResponse
    {
        Product::create([
            'vendor_id' => $this->vendorId(),
            ...$this->validatedData($request),
        ]);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Redirect the show route to edit to keep the resource simple.
     */
    public function show(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        return redirect()->route('vendor.products.edit', $product);
    }

    /**
     * Show the edit form for one vendor-owned product.
     */
    public function edit(string $id): View
    {
        $product = $this->findVendorProduct($id);
        $categories = Category::orderBy('id')->get();

        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update one vendor-owned product.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        $product->update($this->validatedData($request));

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Delete one vendor-owned product.
     */
    public function destroy(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        $product->delete();

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Find a product only if it belongs to the current vendor.
     */
    private function findVendorProduct(string $id): Product
    {
        return Product::where('vendor_id', $this->vendorId())->findOrFail($id);
    }

    /**
     * Resolve the current vendor profile primary key.
     */
    private function vendorId(): int
    {
        return (int) auth()->user()->vendorProfile->getKey();
    }

    /**
     * Validate product form data using the current schema.
     */
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
