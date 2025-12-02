@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-premium">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Edit Produk</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="name" class="form-control"
                               value="{{ old('name', $product->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="category" class="form-control"
                               value="{{ old('category', $product->category) }}">
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Material</label>
                            <input type="text" name="material" class="form-control"
                                   value="{{ old('material', $product->material) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Warna</label>
                            <input type="text" name="color" class="form-control"
                                   value="{{ old('color', $product->color) }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ukuran</label>
                            <input type="text" name="size" class="form-control"
                                   value="{{ old('size', $product->size) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control"
                                   value="{{ old('price', $product->price) }}" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Minimal Stok</label>
                            <input type="number" name="min_stock" class="form-control"
                                   value="{{ old('min_stock', $product->min_stock) }}" min="0" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Foto Produk</label>
                        @if($product->image_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$product->image_path) }}"
                                     class="product-thumb"
                                     alt="{{ $product->name }}">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <small class="text-muted">
                            Biarkan kosong jika tidak ingin mengganti foto. Ukuran maks. 2MB.
                        </small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('products.index') }}" class="btn btn-link">
                            Batal
                        </a>
                        <button class="btn btn-primary">
                            Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
