<?php

use App\Http\Requests\BookRequest;
use App\Http\Requests\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use App\Services\GroqService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        $books = Book::latest()->get();

        return view('library.dashboard', [
            'summary' => [
                'total_books' => Book::count(),
                'total_loans' => Loan::count(),
                'available_books' => Book::sum('stock'),
            ],
            'books' => $books,
        ]);
    })->name('dashboard');

    Route::get('/books', function (Illuminate\Http\Request $request) {
        return view('library.books', [
            'books' => Book::latest()->get(),
            'editingBook' => $request->query('edit') ? Book::find($request->query('edit')) : null,
        ]);
    })->name('books.index');

    Route::post('/books', function (BookRequest $request) {
        Book::create($request->validated());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    })->name('books.store');

    Route::put('/books/{book}', function (BookRequest $request, Book $book) {
        $book->update($request->validated());

        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    })->name('books.update');

    Route::delete('/books/{book}', function (Book $book) {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    })->name('books.destroy');

    Route::get('/loans', function () {
        return view('library.loans', [
            'loans' => Loan::with('book')->latest()->get(),
            'books' => Book::orderBy('title')->get(),
        ]);
    })->name('loans.index');

    Route::post('/loans', function (LoanRequest $request) {
        $validated = $request->validated();
        $book = Book::findOrFail($validated['book_id']);

        if ($book->stock < 1) {
            return back()->withInput()->with('error', 'Stok buku tidak tersedia.');
        }

        Loan::create($validated);
        $book->decrement('stock');

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    })->name('loans.store');

    Route::delete('/loans/{loan}', function (Loan $loan) {
        $loan->load('book');

        if ($loan->book) {
            $loan->book->increment('stock');
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Peminjaman berhasil dihapus.');
    })->name('loans.destroy');

    Route::get('/ai-recommendation', function () {
        return view('library.ai-recommendation');
    })->name('ai.recommendation');

    Route::post('/ai-recommendation', function (GroqService $groqService) {
        $books = Book::query()->withCount('loans')->get();
        $loans = Loan::query()->with('book')->latest()->limit(20)->get();

        $analysis = [
            'total_books' => $books->count(),
            'total_loans' => Loan::count(),
            'low_stock_books' => $books->where('stock', '<', 5)->values()->map(fn (Book $book) => [
                'title' => $book->title,
                'author' => $book->author,
                'stock' => $book->stock,
            ])->all(),
            'most_borrowed_books' => $books->sortByDesc('loans_count')->take(5)->values()->map(fn (Book $book) => [
                'title' => $book->title,
                'author' => $book->author,
                'loans_count' => $book->loans_count,
            ])->all(),
            'recent_loans' => $loans->map(fn (Loan $loan) => [
                'book' => $loan->book?->title,
                'borrower_name' => $loan->borrower_name,
                'borrow_date' => optional($loan->borrow_date)->toDateString(),
                'return_date' => optional($loan->return_date)->toDateString(),
            ])->all(),
        ];

        $result = $groqService->recommendLibrary($analysis);

        if (! $result['success']) {
            return back()->with('error', $result['error'] ?? 'Gagal memproses rekomendasi AI.');
        }

        return view('library.ai-recommendation', [
            'analysis' => $analysis,
            'recommendation' => $result['content'],
        ]);
    })->name('ai.recommendation.run');

});
