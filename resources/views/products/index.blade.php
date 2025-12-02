@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="row mb-3">
    <div class="col-md-8">
        <h2 class="page-header-title mb-0">Daftar Produk Furniture</h2>
        <small class="text-muted page-header-subtitle">
            Kelola stok dan tampilan produk dengan dashboard yang elegan.
        </small>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0">
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            + Tambah Produk
        </a>
    </div>
</div>

<div class="card card-premium">
    <div class="card-body">
        <form method="GET" class="row g-2 mb-3">
            <div class="col-md-10">
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama atau kategori..."
                       value="{{ $search }}">
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-outline-secondary">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Min Stok</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $loop->iteration + ($products->currentPage()-1)*$products->perPage() }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/'.$product->image_path) }}"
                                         class="product-thumb-sm me-3"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="product-thumb-sm me-3 d-flex align-items-center justify-content-center bg-light border">
                                        <span class="text-muted small">No Img</span>
                                    </div>
                                @endif
                                <div>
                                    <a href="{{ route('products.show', $product) }}"
                                       class="fw-semibold text-decoration-none">
                                        {{ $product->name }}
                                    </a>
                                    <div class="small text-muted">
                                        {{ $product->material ?? 'Material tidak diisi' }}
                                    </div>
                                    @if($product->isLowStock())
                                        <span class="badge-low-stock mt-1 d-inline-block">Stok Menipis</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $product->category ?? '-' }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->min_stock }}</td>
                        <td class="text-end">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary me-1">
                                Edit
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Belum ada produk. Tambahkan dulu yuk.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
