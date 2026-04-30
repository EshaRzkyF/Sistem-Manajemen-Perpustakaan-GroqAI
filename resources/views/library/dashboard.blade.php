@extends('layouts.app')

@section('content')
<div class="hero-card text-white rounded-4 shadow-lg p-4 p-lg-5 mb-4">
    <div class="row align-items-center g-4">
        <div class="col-lg-8">
            <span class="badge text-bg-light text-primary mb-3">Dashboard</span>
            <h1 class="display-6 fw-bold mb-3">Sistem Manajemen Perpustakaan</h1>
            <p class="lead mb-0 text-white-75">Pantau koleksi, peminjaman, dan rekomendasi AI dalam satu tampilan yang rapi dan responsif.</p>
        </div>
        <div class="col-lg-4 text-lg-end">
            <div class="bg-white bg-opacity-10 rounded-4 p-3 d-inline-block">
                <div class="small text-white-50">Total Buku</div>
                <div class="fs-1 fw-bold">{{ $summary['total_books'] }}</div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Total Buku</p>
                        <h3 class="mb-0 fw-bold">{{ $summary['total_books'] }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-3">
                        <i class="bi bi-book fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Total Peminjaman</p>
                        <h3 class="mb-0 fw-bold">{{ $summary['total_loans'] }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded-circle p-3">
                        <i class="bi bi-arrow-left-right fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-secondary mb-1">Buku Tersedia</p>
                        <h3 class="mb-0 fw-bold">{{ $summary['available_books'] }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded-circle p-3">
                        <i class="bi bi-stack fs-3"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div>
                <h5 class="mb-1 fw-bold">Ringkasan Koleksi</h5>
                <p class="text-secondary mb-0">Data terbaru dari buku dan peminjaman.</p>
            </div>
            <a href="{{ route('books.index') }}" class="btn btn-primary"><i class="bi bi-arrow-right-circle me-2"></i>Lihat Buku</a>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td class="fw-medium">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->year }}</td>
                            <td><span class="badge {{ $book->stock > 0 ? 'text-bg-success' : 'text-bg-danger' }}">{{ $book->stock }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-secondary">Belum ada data buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
