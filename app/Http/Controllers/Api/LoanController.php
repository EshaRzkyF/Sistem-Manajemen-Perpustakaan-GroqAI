<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoanRequest;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoanController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Loan::with('book')->latest()->get(),
        ]);
    }

    public function store(LoanRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $loan = DB::transaction(function () use ($validated) {
            $book = Book::query()
                ->whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->stock < 1) {
                throw ValidationException::withMessages([
                    'book_id' => 'Stok buku tidak tersedia.',
                ]);
            }

            $loan = Loan::create($validated);
            $book->decrement('stock');

            return $loan->load('book');
        });

        return response()->json([
            'success' => true,
            'data' => $loan,
        ], 201);
    }

    public function destroy(Loan $loan): JsonResponse
    {
        DB::transaction(function () use ($loan) {
            $loan->loadMissing('book');

            if ($loan->book) {
                $book = Book::query()
                    ->whereKey($loan->book_id)
                    ->lockForUpdate()
                    ->first();

                if ($book) {
                    $book->increment('stock');
                }
            }

            $loan->delete();
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $loan->id,
            ],
        ]);
    }
}
