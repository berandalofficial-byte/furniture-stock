@extends('layouts.app')

@section('title', 'Transaksi Stok')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h2 class="fw-bold mb-0">Transaksi Stok</h2>
        <small class="text-muted">Riwayat keluar-masuk stok semua produk.</small>
    </div>
    <a href="{{ route('stock-transactions.create') }}" class="btn btn-primary">
        + Transaksi Baru
    </a>
</div>

<div class="card card-premium">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Produk</th>
                        <th>Jenis</th>
                        <th>Qty</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transactions as $trx)
                    <tr>
                        <td>{{ $loop->iteration + ($transactions->currentPage()-1)*$transactions->perPage() }}</td>
                        <td>{{ $trx->product->name ?? '-' }}</td>
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
                        <td class="text-end">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('stock-transactions.edit', $trx) }}"
                               class="btn btn-sm btn-outline-primary me-1">
                                Edit
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('stock-transactions.destroy', $trx) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus transaksi ini? Stok akan ikut disesuaikan.');">
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
                            Belum ada transaksi stok.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $transactions->links() }}
    </div>
</div>
@endsection
