@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <h2 class="page-header-title mb-1">{{ $product->name }}</h2>
        <small class="text-muted page-header-subtitle">
            Detail produk dan riwayat transaksi stok.
        </small>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            &larr; Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <div class="card card-premium">
            <div class="card-body">
                @if($product->image_path)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/'.$product->image_path) }}"
                             class="product-thumb"
                             style="width: 100%; max-width: 260px; height: 260px; object-fit: cover; border-radius: 20px;"
                             alt="{{ $product->name }}">
                    </div>
                @endif
                <h5 class="fw-bold mb-3">Informasi Produk</h5>
                <p class="mb-1"><strong>Kategori:</strong> {{ $product->category ?? '-' }}</p>
                <p class="mb-1"><strong>Material:</strong> {{ $product->material ?? '-' }}</p>
                <p class="mb-1"><strong>Warna:</strong> {{ $product->color ?? '-' }}</p>
                <p class="mb-1"><strong>Ukuran:</strong> {{ $product->size ?? '-' }}</p>
                <p class="mb-1"><strong>Harga:</strong> Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="mb-1">
                    <strong>Stok:</strong> {{ $product->stock }}
                    @if($product->isLowStock())
                        <span class="badge-low-stock ms-2">Stok Menipis</span>
                    @endif
                </p>
                <p class="mb-0"><strong>Minimal Stok:</strong> {{ $product->min_stock }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-8 mb-3">
        <div class="card card-premium">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="fw-bold mb-0">Riwayat Transaksi Stok</h5>
                    <a href="{{ route('stock-transactions.create') }}" class="btn btn-sm btn-primary">
                        + Transaksi Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Jenis</th>
                                <th>Qty</th>
                                <th>Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $trx)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if($trx->type === 'in')
                                        <span class="badge bg-success pill">Masuk</span>
                                    @else
                                        <span class="badge bg-danger pill">Keluar</span>
                                    @endif
                                </td>
                                <td>{{ $trx->qty }}</td>
                                <td>{{ $trx->transacted_at->format('d M Y H:i') }}</td>
                                <td>{{ $trx->description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada transaksi stok untuk produk ini.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
