<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('category_name')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'barcode' => 'nullable|string|max:255|unique:products,barcode',
            'purchase_price' => 'required|integer|min:0',
            'selling_price' => 'required|integer|min:0|gte:purchase_price',
            'unit' => 'required|string|max:50',
        ]);

        if (blank($validated['barcode'] ?? null)) {
            $validated['barcode'] = null;
        }

        DB::beginTransaction();

        try {
            $product = Product::create($validated);

            foreach (Branch::all() as $branch) {
                Stock::create([
                    'branch_id' => $branch->id,
                    'product_id' => $product->id,
                    'quantity' => 0,
                ]);
            }

            DB::commit();

            return redirect()->route('products.index')
                ->with('success', 'Produk berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('category_name')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'product_name' => 'required|string|max:255',
            'barcode' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'barcode')->ignore($product->id),
            ],
            'purchase_price' => 'required|integer|min:0',
            'selling_price' => 'required|integer|min:0|gte:purchase_price',
            'unit' => 'required|string|max:50',
        ]);

        if (blank($validated['barcode'] ?? null)) {
            $validated['barcode'] = null;
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->transactionDetails()->exists()) {
            return redirect()->route('products.index')
                ->with('error', 'Produk tidak dapat dihapus karena sudah digunakan dalam transaksi.');
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
