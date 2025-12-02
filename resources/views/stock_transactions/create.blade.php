@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-premium">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Tambah Transaksi Stok</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stock-transactions.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <select name="product_id" class="form-select" required>
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} (Stok: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <select name="type" class="form-select" required>
                                <option value="in" {{ old('type') == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ old('type') == 'out' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="qty" class="form-control"
                                   value="{{ old('qty', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="datetime-local" name="transacted_at" class="form-control"
                                   value="{{ old('transacted_at') ?? now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="description" class="form-control"
                               value="{{ old('description') }}" placeholder="Contoh: stok baru datang">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('stock-transactions.index') }}" class="btn btn-link">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
