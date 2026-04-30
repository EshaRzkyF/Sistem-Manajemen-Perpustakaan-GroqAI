@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Data Buku</h1>
        <p class="text-secondary mb-0">Kelola koleksi buku perpustakaan.</p>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-bold">Daftar Buku</h5>
                    <span class="badge text-bg-primary">{{ $books->count() }} data</span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td class="fw-semibold">{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->year }}</td>
                                    <td><span class="badge {{ $book->stock > 0 ? 'text-bg-success' : 'text-bg-danger' }}">{{ $book->stock }}</span></td>
                                    <td class="text-end">
                                        <a href="{{ route('books.index', ['edit' => $book->id]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-secondary">Belum ada buku.</td>
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
                <h5 class="fw-bold mb-3">{{ $editingBook ? 'Edit Buku' : 'Tambah Buku' }}</h5>

                <form action="{{ $editingBook ? route('books.update', $editingBook) : route('books.store') }}" method="POST" class="row g-3">
                    @csrf
                    @if($editingBook)
                        @method('PUT')
                    @endif

                    <div class="col-12">
                        <label class="form-label">Judul</label>
                        <input type="text" name="title" value="{{ old('title', $editingBook->title ?? '') }}" class="form-control @error('title') is-invalid @enderror" placeholder="Masukkan judul buku">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="author" value="{{ old('author', $editingBook->author ?? '') }}" class="form-control @error('author') is-invalid @enderror" placeholder="Nama penulis">
                        @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="year" value="{{ old('year', $editingBook->year ?? '') }}" class="form-control @error('year') is-invalid @enderror" placeholder="2026">
                        @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $editingBook->stock ?? 0) }}" class="form-control @error('stock') is-invalid @enderror" placeholder="0">
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-12 d-flex gap-2">
                        <button class="btn btn-primary">{{ $editingBook ? 'Simpan Perubahan' : 'Tambah Buku' }}</button>
                        @if($editingBook)
                            <a href="{{ route('books.index') }}" class="btn btn-outline-secondary">Batal</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
