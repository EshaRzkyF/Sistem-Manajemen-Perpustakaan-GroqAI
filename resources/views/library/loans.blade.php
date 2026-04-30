@extends('layouts.app')

@section('content')
<div class="mb-6 flex flex-wrap items-end justify-between gap-3">
    <div>
        <h2 class="text-2xl font-semibold text-slate-900">Loans Management</h2>
        <p class="mt-1 text-sm text-slate-500">Pantau riwayat peminjaman dan kembalikan stok secara otomatis.</p>
    </div>
    <span class="rounded-full bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white">{{ $loans->count() }} transaksi</span>
</div>

<div class="grid gap-6 xl:grid-cols-[1.5fr_1fr]">
    <section class="rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
            <h3 class="text-lg font-semibold text-slate-900">Daftar Peminjaman</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Peminjam</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Judul Buku</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Tanggal Pinjam</th>
                        <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Tanggal Kembali</th>
                        <th class="px-5 py-3 text-right font-semibold text-slate-600 sm:px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white">
                    @forelse($loans as $loan)
                        <tr class="hover:bg-slate-50/70">
                            <td class="px-5 py-3 font-medium text-slate-900 sm:px-6">{{ $loan->borrower_name }}</td>
                            <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $loan->book?->title ?? '-' }}</td>
                            <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $loan->borrow_date?->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $loan->return_date?->format('d M Y') }}</td>
                            <td class="px-5 py-3 text-right sm:px-6">
                                <form action="{{ route('loans.destroy', $loan) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data peminjaman ini? Stok buku akan dikembalikan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-medium text-rose-700 transition hover:bg-rose-50">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-slate-500 sm:px-6">Belum ada data peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <section class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
        <h3 class="text-lg font-semibold text-slate-900">Tambah Peminjaman</h3>
        <p class="mt-1 text-sm text-slate-500">Pilih buku dan isi jadwal pinjam.</p>

        <form action="{{ route('loans.store') }}" method="POST" class="mt-5 space-y-4">
            @csrf

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Nama Peminjam</label>
                <input type="text" name="borrower_name" value="{{ old('borrower_name') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200" placeholder="Masukkan nama peminjam">
                @error('borrower_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">Pilih Buku</label>
                <select name="book_id" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    <option value="">-- Pilih buku --</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" @selected(old('book_id') == $book->id)>{{ $book->title }} - {{ $book->author }}</option>
                    @endforeach
                </select>
                @error('book_id')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Pinjam</label>
                    <input type="date" name="borrow_date" value="{{ old('borrow_date') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @error('borrow_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">Tanggal Kembali</label>
                    <input type="date" name="return_date" value="{{ old('return_date') }}" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm text-slate-900 focus:border-slate-500 focus:outline-none focus:ring-2 focus:ring-slate-200">
                    @error('return_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="pt-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-700">Tambah Peminjaman</button>
            </div>
        </form>
    </section>
</div>
@endsection
