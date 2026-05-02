<?php

namespace App\Http\Controllers\Vendor;

use App\Enums\ProductAvailabilityStatus;
use App\Enums\ProductType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function createPrebuilt(): View
    {
        $prebuiltCategory = $this->prebuiltCategory();

        return view('vendor.products.create-prebuilt', compact('prebuiltCategory'));
    }

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

    public function storePrebuilt(Request $request): RedirectResponse
    {
        $data = $this->validatedPrebuiltData($request);

        Product::create([
            'vendor_id' => $this->vendorId(),
            'category_id' => $this->prebuiltCategory()->id,
            'name' => $data['name'],
            'description' => $this->buildPrebuiltDescription($data),
            'technical_specs' => $this->buildPrebuiltSpecs($data),
            'price' => $data['price'],
            'stock_quantity' => $data['stock_quantity'],
            'availability_status' => $data['availability_status'],
            'image_url' => $data['image_url'] ?: null,
            'product_type' => ProductType::PREBUILT_PC->value,
        ]);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Prebuilt PC launched successfully.');
    }

    public function show(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        return redirect()->route('vendor.products.edit', $product);
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
            ->route('vendor.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $product = $this->findVendorProduct($id);

        $product->delete();

        return redirect()
            ->route('vendor.products.index')
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
            'availability_status' => ['required', Rule::in(ProductAvailabilityStatus::values())],
            'image_url' => ['nullable', 'url', 'max:255'],
            'product_type' => ['required', Rule::in(ProductType::values())],
        ]);
    }

    private function validatedPrebuiltData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'availability_status' => ['required', Rule::in(ProductAvailabilityStatus::values())],
            'image_url' => ['nullable', 'url', 'max:255'],
            'cpu' => ['required', 'string', 'max:255'],
            'gpu' => ['nullable', 'string', 'max:255'],
            'ram' => ['required', 'string', 'max:255'],
            'motherboard' => ['nullable', 'string', 'max:255'],
            'ssd' => ['nullable', 'string', 'max:255'],
            'hdd' => ['nullable', 'string', 'max:255'],
            'power_supply' => ['nullable', 'string', 'max:255'],
            'pc_case' => ['nullable', 'string', 'max:255'],
            'cpu_cooler' => ['nullable', 'string', 'max:255'],
            'case_fans' => ['nullable', 'string', 'max:255'],
            'operating_system' => ['nullable', 'string', 'max:255'],
            'connectivity' => ['nullable', 'string', 'max:255'],
            'vendor_notes' => ['nullable', 'string'],
        ]);
    }

    private function prebuiltCategory(): Category
    {
        return Category::firstOrCreate(['name' => 'Prebuilt PCs']);
    }

    private function buildPrebuiltDescription(array $data): string
    {
        $lines = [
            $data['name'] . ' is a ready-to-launch prebuilt PC configured for buyers who want a complete setup without choosing each part manually.',
            'Core hardware: CPU ' . $data['cpu'] . ', RAM ' . $data['ram'] . ($data['gpu'] ? ', GPU ' . $data['gpu'] : '') . '.',
        ];

        $optionalParts = [
            'Motherboard' => $data['motherboard'],
            'SSD' => $data['ssd'],
            'HDD' => $data['hdd'],
            'Power Supply' => $data['power_supply'],
            'Case' => $data['pc_case'],
            'CPU Cooler' => $data['cpu_cooler'],
            'Case Fans' => $data['case_fans'],
            'Operating System' => $data['operating_system'],
            'Connectivity' => $data['connectivity'],
        ];

        $filledParts = collect($optionalParts)
            ->filter()
            ->map(fn (string $value, string $label) => $label . ': ' . $value)
            ->values()
            ->all();

        if ($filledParts !== []) {
            $lines[] = 'Included components: ' . implode(' | ', $filledParts) . '.';
        }

        if (! empty($data['vendor_notes'])) {
            $lines[] = trim($data['vendor_notes']);
        }

        return implode("\n\n", $lines);
    }

    private function buildPrebuiltSpecs(array $data): string
    {
        $specs = [
            'CPU' => $data['cpu'],
            'GPU' => $data['gpu'],
            'RAM' => $data['ram'],
            'Motherboard' => $data['motherboard'],
            'SSD' => $data['ssd'],
            'HDD' => $data['hdd'],
            'Power Supply' => $data['power_supply'],
            'Case' => $data['pc_case'],
            'CPU Cooler' => $data['cpu_cooler'],
            'Case Fans' => $data['case_fans'],
            'Operating System' => $data['operating_system'],
            'Connectivity' => $data['connectivity'],
        ];

        return collect($specs)
            ->filter()
            ->map(fn (string $value, string $label) => $label . ': ' . $value)
            ->implode("\n");
    }
}
