<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => Book::latest()->get(),
        ]);
    }

    public function store(BookRequest $request): JsonResponse
    {
        $book = Book::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $book,
        ], 201);
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $book,
        ]);
    }

    public function update(BookRequest $request, Book $book): JsonResponse
    {
        $book->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $book->fresh(),
        ]);
    }

    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $book->id,
            ],
        ]);
    }
}
