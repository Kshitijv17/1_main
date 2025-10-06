<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Shop;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // Admin can view ALL products from ALL shops for oversight
        $products = Product::with(['category', 'images', 'shop', 'shop.admin'])
                          ->latest()
                          ->get();

        // Calculate global statistics for admin oversight
        $stats = [
            'total_products' => $products->count(),
            'active_products' => $products->where('is_active', true)->count(),
            'inactive_products' => $products->where('is_active', false)->count(),
            'featured_products' => $products->where('is_featured', true)->count(),
            'out_of_stock' => $products->where('stock_status', 'out_of_stock')->count(),
            'low_stock' => $products->where('quantity', '<=', 10)->where('quantity', '>', 0)->count(),
            'total_shops' => $products->pluck('shop_id')->unique()->count(),
        ];

        return view('admin.products.index', compact('products', 'stats'));
    }

    public function create()
    {
        // Admin can create products for any shop
        $categories = Category::where('status', 'active')->get();
        $shops = Shop::where('is_active', true)->get();
        
        return view('admin.products.create', compact('categories', 'shops'));
    }

    public function store(Request $request)
    {
        try {
            // Admin can create products for any shop
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'features' => 'nullable|string',
                'specifications' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'selling_price' => 'nullable|numeric|min:0',
                'discount_tag' => 'nullable|string|max:50',
                'discount_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
                'quantity' => 'required|integer|min:0',
                'stock_status' => 'required|in:in_stock,out_of_stock',
                'is_active' => 'required|boolean',
                'is_featured' => 'nullable|boolean',
                'category_id' => 'required|exists:categories,id',
                'shop_id' => 'required|exists:shops,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'images' => 'nullable|array|max:10',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $data = $request->all();

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($data);

            // Handle multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index,
                    ]);
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product added successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Product $product)
    {
        // Admin can edit ANY product from ANY shop for oversight
        $categories = Category::where('status', 'active')->get();
        $shops = Shop::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories', 'shops'));
    }

    public function show(Product $product)
    {
        // Admin can view ANY product from ANY shop for oversight
        $product->load('category', 'images', 'shop', 'shop.vendor');
        return view('admin.products.show', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Admin can update ANY product from ANY shop for oversight
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'specifications' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'selling_price' => 'nullable|numeric|min:0',
            'discount_tag' => 'nullable|string|max:50',
            'discount_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
            'quantity' => 'required|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock',
            'is_active' => 'required|boolean',
            'is_featured' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
            'shop_id' => 'required|exists:shops,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'nullable|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            $nextSortOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => ++$nextSortOrder,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Admin can delete ANY product from ANY shop for oversight
        
        // Delete main image if exists
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete additional images
        foreach ($product->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }

    public function deleteImage(ProductImage $image)
    {
        // Admin can delete ANY product image from ANY shop for oversight
        
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return response()->json(['success' => true]);
    }

    public function bulkUploadForm()
    {
        // Admin can bulk upload products for any shop
        $shops = Shop::where('is_active', true)->get();
        return view('admin.products.bulk-upload', compact('shops'));
    }

    public function bulkUpload(Request $request)
    {
        // Admin can bulk upload products for any shop
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
            'shop_id' => 'required|exists:shops,id',
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));

        // Remove header row
        array_shift($data);

        $errors = [];
        $successCount = 0;
        $totalCount = count($data);

        foreach ($data as $index => $row) {
            try {
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Map CSV columns to product fields
                $productData = [
                    'title' => $row[0] ?? '',
                    'description' => $row[1] ?? '',
                    'features' => $row[2] ?? '',
                    'specifications' => $row[3] ?? '',
                    'price' => $row[4] ?? '',
                    'selling_price' => $row[5] ?? null,
                    'quantity' => $row[6] ?? 0,
                    'stock_status' => $row[7] ?? 'in_stock',
                    'is_active' => strtolower($row[8] ?? 'active') === 'active' ? 1 : 0,
                    'category_id' => $this->getCategoryId($row[9] ?? ''),
                    'discount_tag' => $row[10] ?? null,
                    'discount_color' => $row[11] ?? '#FF0000',
                    'shop_id' => $request->shop_id, // Assign to selected shop
                ];

                // Validate individual product data
                $validator = Validator::make($productData, [
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'features' => 'nullable|string',
                    'specifications' => 'nullable|string',
                    'price' => 'required|numeric|min:0',
                    'selling_price' => 'nullable|numeric|min:0',
                    'quantity' => 'required|integer|min:0',
                    'stock_status' => 'required|in:in_stock,out_of_stock',
                    'is_active' => 'required|boolean',
                    'category_id' => 'required|exists:categories,id',
                    'discount_tag' => 'nullable|string|max:50',
                    'discount_color' => 'nullable|string|regex:/^#[a-fA-F0-9]{6}$/',
                    'shop_id' => 'required|exists:shops,id',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Row " . ($index + 2) . ": " . implode(', ', $validator->errors()->all());
                    continue;
                }

                // Create the product
                Product::create($productData);
                $successCount++;

            } catch (\Exception $e) {
                $errors[] = "Row " . ($index + 2) . ": " . $e->getMessage();
            }
        }

        if ($successCount > 0) {
            $message = "Successfully uploaded {$successCount} out of {$totalCount} products to your shop.";
            if (!empty($errors)) {
                $message .= " Some products had errors and were skipped.";
            }
            return redirect()->route('admin.products.index')->with('success', $message)->with('bulk_errors', $errors);
        } else {
            return redirect()->back()->with('error', 'No products were uploaded. Please check your CSV file format.')->with('bulk_errors', $errors);
        }
    }

    public function downloadCsvTemplate()
    {
        $filename = 'products_bulk_upload_template.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $template = [
            ['Title', 'Description', 'Features', 'Specifications', 'Price', 'Selling Price', 'Quantity', 'Stock Status', 'Status', 'Category Title', 'Discount Tag', 'Discount Color'],
            ['Sample Product 1', 'This is a sample product description', 'Feature 1, Feature 2, Feature 3', 'Spec 1: Value, Spec 2: Value', '100.00', '80.00', '50', 'in_stock', 'active', 'Electronics', '20% OFF', '#FF0000'],
            ['Sample Product 2', 'Another product description', '', '', '200.00', '', '25', 'out_of_stock', 'inactive', 'Clothing', '', '#00FF00'],
        ];

        $callback = function() use ($template) {
            $file = fopen('php://output', 'w');
            foreach ($template as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getCategoryId($categoryName)
    {
        if (empty($categoryName)) {
            return null;
        }

        $category = Category::where('title', 'LIKE', '%' . trim($categoryName) . '%')->first();

        if (!$category) {
            // Create category if it doesn't exist
            $category = Category::create([
                'title' => trim($categoryName),
                'slug' => Str::slug(trim($categoryName)),
                'description' => 'Auto-created from bulk upload',
                'is_active' => true,
            ]);
        }

        return $category->id;
    }

    /**
     * Toggle product status (active/inactive)
     */
    public function toggleStatus(Product $product)
    {
        // Admin can toggle status of ANY product from ANY shop for oversight
        $product->is_active = !$product->is_active;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Product status updated successfully',
            'is_active' => $product->is_active,
            'status_text' => $product->is_active ? 'Active' : 'Inactive'
        ]);
    }
}
