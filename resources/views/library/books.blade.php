@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div>
        <h2 class="text-2xl font-semibold text-slate-900">Books CRUD</h2>
        <p class="mt-1 text-sm text-slate-500">Kelola koleksi buku, stok, dan metadata katalog.</p>
    </div>
    <span class="rounded-full bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white">{{ $books->count() }} data buku</span>
</div>

<div class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h3 class="text-lg font-semibold text-slate-900">Daftar Buku</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Judul</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Penulis</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Tahun</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Stok</th>
                        <th class="px-5 py-3 text-right font-semibold text-slate-600 sm:px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($books as $book)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-3 font-medium text-slate-900 sm:px-6">{{ $book->title }}</td>
                            <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $book->author }}</td>
                            <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $book->year }}</td>
                            <td class="px-5 py-3 sm:px-6">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $book->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $book->stock }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right sm:px-6">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('books.index', ['edit' => $book->id]) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 transition hover:bg-slate-100">Edit</a>
                                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-medium text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-500 sm:px-6">Belum ada buku.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="text-lg font-semibold text-slate-900">{{ $editingBook ? 'Edit Buku' : 'Tambah Buku' }}</h3>
        <p class="mt-1 text-sm text-slate-500">Lengkapi data buku di bawah ini.</p>

        <form action="{{ $editingBook ? route('books.update', $editingBook) : route('books.store') }}" method="POST" class="mt-5 space-y-4">
            @csrf
            @if($editingBook)
                @method('PUT')
            @endif

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Judul</label>
                <input type="text" name="title" value="{{ old('title', $editingBook->title ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="Masukkan judul buku">
                @error('title')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Penulis</label>
                <input type="text" name="author" value="{{ old('author', $editingBook->author ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="Nama penulis">
                @error('author')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Tahun</label>
                    <input type="number" name="year" value="{{ old('year', $editingBook->year ?? '') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="2026">
                    @error('year')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $editingBook->stock ?? 0) }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="0">
                    @error('stock')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex flex-wrap gap-2 pt-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">{{ $editingBook ? 'Simpan Perubahan' : 'Tambah Buku' }}</button>
                @if($editingBook)
                    <a href="{{ route('books.index') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">Batal</a>
                @endif
            </div>
        </form>
    </section>
</div>
@endsection
