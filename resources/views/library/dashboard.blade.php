@extends('layouts.app')

@section('content')
<div class="mb-6 overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-emerald-800 p-6 text-white shadow-lg sm:p-8">
    <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
        <div>
            <p class="mb-3 inline-flex rounded-full border border-white/20 px-3 py-1 text-xs font-medium">Library Dashboard</p>
            <h2 class="text-2xl font-semibold sm:text-3xl">Sistem Manajemen Perpustakaan</h2>
            <p class="mt-3 max-w-2xl text-sm text-slate-200 sm:text-base">Pantau koleksi buku, pergerakan peminjaman, dan produktivitas tim dari satu tampilan yang bersih dan responsif.</p>
        </div>
        <div class="rounded-2xl border border-white/15 bg-white/10 p-4 text-center backdrop-blur">
            <p class="text-xs uppercase tracking-wider text-slate-200">Total Buku</p>
            <p class="mt-1 text-4xl font-bold">{{ $summary['total_books'] }}</p>
        </div>
    </div>
</div>

<div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Total Buku</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['total_books'] }}</p>
        <p class="mt-1 text-xs text-slate-500">Semua koleksi terdaftar</p>
    </article>

    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <p class="text-sm text-slate-500">Total Peminjaman</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['total_loans'] }}</p>
        <p class="mt-1 text-xs text-slate-500">Riwayat transaksi buku</p>
    </article>

    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:col-span-2 xl:col-span-1">
        <p class="text-sm text-slate-500">Buku Tersedia</p>
        <p class="mt-2 text-3xl font-bold text-slate-900">{{ $summary['available_books'] }}</p>
        <p class="mt-1 text-xs text-slate-500">Jumlah stok siap pinjam</p>
    </article>
</div>

<section class="rounded-3xl border border-slate-200 bg-white shadow-sm">
    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-5 py-4 sm:px-6">
        <div>
            <h3 class="text-lg font-semibold text-slate-900">Ringkasan Koleksi</h3>
            <p class="text-sm text-slate-500">Data buku terbaru pada sistem.</p>
        </div>
        <a href="{{ route('books.index') }}" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-700">Kelola Buku</a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Judul</th>
                    <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Penulis</th>
                    <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Tahun</th>
                    <th class="px-5 py-3 text-left font-semibold text-slate-600 sm:px-6">Stok</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse($books as $book)
                    <tr>
                        <td class="px-5 py-3 font-medium text-slate-900 sm:px-6">{{ $book->title }}</td>
                        <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $book->author }}</td>
                        <td class="px-5 py-3 text-slate-700 sm:px-6">{{ $book->year }}</td>
                        <td class="px-5 py-3 sm:px-6">
                            <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $book->stock > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                {{ $book->stock }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-10 text-center text-slate-500 sm:px-6">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
