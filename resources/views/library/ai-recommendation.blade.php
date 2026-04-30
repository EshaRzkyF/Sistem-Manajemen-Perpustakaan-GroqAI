@extends('layouts.app')

@section('content')
<div class="row g-4 align-items-start">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <span class="badge text-bg-primary mb-3">Groq AI</span>
                <h1 class="h3 fw-bold mb-2">AI Rekomendasi Perpustakaan</h1>
                <p class="text-secondary mb-4">Tekan tombol di bawah untuk menganalisa koleksi buku, tren peminjaman, dan saran pengelolaan perpustakaan.</p>

                <form action="{{ route('ai.recommendation.run') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-stars me-2"></i>Analisa Buku
                    </button>
                </form>

                <div class="mt-3 small text-secondary">
                    Model: <strong>llama-3.1-8b-instant</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Hasil Rekomendasi</h5>
                        <p class="text-secondary mb-0">Ringkasan analisa dan saran AI akan tampil di sini.</p>
                    </div>
                    @if(isset($analysis))
                        <span class="badge text-bg-success">Selesai</span>
                    @else
                        <span class="badge text-bg-secondary">Belum dianalisis</span>
                    @endif
                </div>

                @if(isset($analysis))
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="text-secondary small">Total Buku</div>
                                <div class="fs-4 fw-bold">{{ $analysis['total_books'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="text-secondary small">Total Peminjaman</div>
                                <div class="fs-4 fw-bold">{{ $analysis['total_loans'] }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 rounded-3 bg-light border">
                                <div class="text-secondary small">Buku Stok Rendah</div>
                                <div class="fs-4 fw-bold">{{ count($analysis['low_stock_books']) }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <textarea class="form-control" rows="16" readonly placeholder="Hasil rekomendasi AI akan muncul di sini.">@if(isset($recommendation)){{ $recommendation }}@endif</textarea>

                @if(session('error'))
                    <div class="alert alert-danger mt-3 mb-0">{{ session('error') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
