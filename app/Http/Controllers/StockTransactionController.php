<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockTransaction; // ✅ WAJIB ADA INI
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockTransactionController extends Controller
{
    // LIST SEMUA TRANSAKSI
    public function index()
    {
        $transactions = StockTransaction::with('product')
            ->orderBy('transacted_at', 'desc')
            ->paginate(15);

        return view('stock_transactions.index', compact('transactions'));
    }

    // FORM TRANSAKSI BARU
    public function create()
    {
        $products = Product::orderBy('name')->get();

        return view('stock_transactions.create', compact('products'));
    }

    // SIMPAN TRANSAKSI BARU + UPDATE STOK
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'    => 'required|exists:products,id',
            'type'          => 'required|in:in,out',
            'qty'           => 'required|integer|min:1',
            'description'   => 'nullable|string|max:255',
            'transacted_at' => 'required|date',
        ]);

        DB::transaction(function () use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            if ($data['type'] === 'in') {
                $product->stock += $data['qty'];
            } else {
                if ($product->stock < $data['qty']) {
                    abort(400, 'Stok produk tidak mencukupi untuk transaksi keluar.');
                }
                $product->stock -= $data['qty'];
            }

            $product->save();

            StockTransaction::create($data);
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Transaksi stok berhasil disimpan.');
    }

    // FORM EDIT TRANSAKSI
    public function edit(StockTransaction $stockTransaction)
    {
        $transaction = $stockTransaction->load('product');

        return view('stock_transactions.edit', compact('transaction'));
    }

    // UPDATE TRANSAKSI + SESUAIKAN STOK
    public function update(Request $request, StockTransaction $stockTransaction)
    {
        $data = $request->validate([
            'type'          => 'required|in:in,out',
            'qty'           => 'required|integer|min:1',
            'description'   => 'nullable|string|max:255',
            'transacted_at' => 'required|date',
        ]);

        DB::transaction(function () use ($data, $stockTransaction) {
            $product = Product::lockForUpdate()->findOrFail($stockTransaction->product_id);

            $oldType = $stockTransaction->type;
            $oldQty  = $stockTransaction->qty;

            // balikin efek transaksi lama
            if ($oldType === 'in') {
                $product->stock -= $oldQty;
            } else {
                $product->stock += $oldQty;
            }

            // terapkan transaksi baru
            if ($data['type'] === 'in') {
                $product->stock += $data['qty'];
            } else {
                if ($product->stock < $data['qty']) {
                    abort(400, 'Stok produk tidak mencukupi untuk transaksi keluar.');
                }
                $product->stock -= $data['qty'];
            }

            if ($product->stock < 0) {
                $product->stock = 0;
            }

            $product->save();

            $stockTransaction->update($data);
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Transaksi stok berhasil diperbarui.');
    }

    // HAPUS TRANSAKSI + KEMBALIKAN STOK
    public function destroy(StockTransaction $stockTransaction)
    {
        DB::transaction(function () use ($stockTransaction) {
            $product = Product::lockForUpdate()->findOrFail($stockTransaction->product_id);

            if ($stockTransaction->type === 'in') {
                $product->stock -= $stockTransaction->qty;
            } else {
                $product->stock += $stockTransaction->qty;
            }

            if ($product->stock < 0) {
                $product->stock = 0;
            }

            $product->save();

            $stockTransaction->delete();
        });

        return redirect()->route('stock-transactions.index')
            ->with('success', 'Transaksi stok berhasil dihapus.');
    }
}
