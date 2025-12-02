<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // LIST PRODUK
    public function index(Request $request)
    {
        $search = $request->get('search');

        $products = Product::when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('products.index', compact('products', 'search'));
    }

    // FORM TAMBAH
    public function create()
    {
        return view('products.create');
    }

    // SIMPAN PRODUK BARU
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'category'  => 'nullable|string|max:255',
            'material'  => 'nullable|string|max:255',
            'color'     => 'nullable|string|max:100',
            'size'      => 'nullable|string|max:100',
            'price'     => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $data['stock'] = 0;

        // upload foto jika ada
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // DETAIL PRODUK + RIWAYAT TRANSAKSI
    public function show(Product $product)
    {
        $transactions = $product->stockTransactions()
            ->orderBy('transacted_at', 'desc')
            ->get();

        return view('products.show', compact('product', 'transactions'));
    }

    // FORM EDIT
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // UPDATE PRODUK
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'category'  => 'nullable|string|max:255',
            'material'  => 'nullable|string|max:255',
            'color'     => 'nullable|string|max:100',
            'size'      => 'nullable|string|max:100',
            'price'     => 'required|numeric|min:0',
            'min_stock' => 'required|integer|min:0',
            'image'     => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        // kalau ada foto baru, hapus yang lama dan simpan yang baru
        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $path = $request->file('image')->store('products', 'public');
            $data['image_path'] = $path;
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // HAPUS PRODUK
    public function destroy(Product $product)
    {
        // hapus foto jika ada
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
