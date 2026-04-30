<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Loan;
use App\Services\GroqService;
use Illuminate\Http\JsonResponse;

class AiController extends Controller
{
    public function recommendation(GroqService $groqService): JsonResponse
    {
        $books = Book::query()->withCount('loans')->get();
        $loans = Loan::query()->with('book')->latest()->limit(20)->get();

        $analysis = [
            'total_books' => $books->count(),
            'total_loans' => Loan::count(),
            'low_stock_books' => $books
                ->where('stock', '<', 5)
                ->values()
                ->map(fn (Book $book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'stock' => $book->stock,
                ])
                ->all(),
            'most_borrowed_books' => $books
                ->sortByDesc('loans_count')
                ->take(5)
                ->values()
                ->map(fn (Book $book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'author' => $book->author,
                    'loans_count' => $book->loans_count,
                    'stock' => $book->stock,
                ])
                ->all(),
            'recent_loans' => $loans->map(fn (Loan $loan) => [
                'id' => $loan->id,
                'book' => $loan->book?->title,
                'borrower_name' => $loan->borrower_name,
                'borrow_date' => optional($loan->borrow_date)->toDateString(),
                'return_date' => optional($loan->return_date)->toDateString(),
            ])->all(),
        ];

        $groqResult = $groqService->recommendLibrary($analysis);

        if (! $groqResult['success']) {
            return response()->json([
                'success' => false,
                'data' => [
                    'analysis' => $analysis,
                    'error' => $groqResult['error'] ?? 'Gagal memproses rekomendasi AI.',
                ],
            ], $groqResult['status'] ?? 500);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'analysis' => $analysis,
                'recommendation' => $groqResult['content'],
            ],
        ]);
    }
}
