@extends('layouts.app')

@section('title', 'Edit Transaksi Stok')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-premium">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Edit Transaksi Stok</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('stock-transactions.update', $transaction) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Produk</label>
                        <input type="text" class="form-control" value="{{ $transaction->product->name ?? '-' }}" disabled>
                        <small class="text-muted">
                            Produk tidak bisa diubah dari sini. Jika salah produk, hapus transaksi ini lalu buat yang baru.
                        </small>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jenis Transaksi</label>
                            <select name="type" class="form-select" required>
                                <option value="in" {{ old('type', $transaction->type) == 'in' ? 'selected' : '' }}>Masuk</option>
                                <option value="out" {{ old('type', $transaction->type) == 'out' ? 'selected' : '' }}>Keluar</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="qty" class="form-control"
                                   value="{{ old('qty', $transaction->qty) }}" min="1" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="datetime-local" name="transacted_at" class="form-control"
                                   value="{{ old('transacted_at', $transaction->transacted_at->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="description" class="form-control"
                               value="{{ old('description', $transaction->description) }}"
                               placeholder="Contoh: stok koreksi, penjualan offline">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('stock-transactions.index') }}" class="btn btn-link">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Update Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
