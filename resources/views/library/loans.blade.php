@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Peminjaman Buku</h1>
        <p class="text-secondary mb-0">Kelola data peminjaman dan pengembalian.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Daftar Peminjaman</h5>
                    <span class="badge text-bg-primary">{{ $loans->count() }} data</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Peminjam</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr>
                                    <td class="fw-semibold">{{ $loan->borrower_name }}</td>
                                    <td>{{ $loan->book?->title ?? '-' }}</td>
                                    <td>{{ $loan->borrow_date?->format('d M Y') }}</td>
                                    <td>{{ $loan->return_date?->format('d M Y') }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data peminjaman ini? Stok buku akan dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-secondary">Belum ada data peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm sticky-top" style="top: 1rem;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3">Tambah Peminjaman</h5>

                <form action="{{ route('loans.store') }}" method="POST" class="row g-3">
                    @csrf

                    <div class="col-12">
                        <label class="form-label">Nama Peminjam</label>
                        <input type="text" name="borrower_name" value="{{ old('borrower_name') }}" class="form-control @error('borrower_name') is-invalid @enderror" placeholder="Masukkan nama peminjam">
                        @error('borrower_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Pilih Buku</label>
                        <select name="book_id" class="form-select @error('book_id') is-invalid @enderror">
                            <option value="">-- Pilih buku --</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>{{ $book->title }} - {{ $book->author }}</option>
                            @endforeach
                        </select>
                        @error('book_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="borrow_date" value="{{ old('borrow_date') }}" class="form-control @error('borrow_date') is-invalid @enderror">
                        @error('borrow_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="return_date" value="{{ old('return_date') }}" class="form-control @error('return_date') is-invalid @enderror">
                        @error('return_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <button class="btn btn-success">Tambah Peminjaman</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
