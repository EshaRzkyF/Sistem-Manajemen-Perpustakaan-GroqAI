<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Loan;
use App\Services\GroqService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LibraryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_rejects_invalid_book_payload(): void
    {
        $this->postJson('/api/books', [
            'title' => '',
            'author' => 'Andrea Hirata',
            'year' => 3000,
            'stock' => -1,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'year', 'stock']);
    }

    public function test_it_can_manage_books(): void
    {
        $createResponse = $this->postJson('/api/books', [
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
            'year' => 2005,
            'stock' => 3,
        ]);

        $createResponse
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.title', 'Laskar Pelangi');

        $this->assertDatabaseHas('books', [
            'title' => 'Laskar Pelangi',
            'author' => 'Andrea Hirata',
        ]);

        $this->getJson('/api/books')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data');
    }

    public function test_it_can_create_and_delete_loans_while_restoring_stock(): void
    {
        $book = Book::create([
            'title' => 'Bumi',
            'author' => 'Tere Liye',
            'year' => 2014,
            'stock' => 1,
        ]);

        $loanResponse = $this->postJson('/api/loans', [
            'book_id' => $book->id,
            'borrower_name' => 'Dina',
            'borrow_date' => '2026-04-30',
            'return_date' => '2026-05-07',
        ]);

        $loanResponse
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.book.id', $book->id);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 0,
        ]);

        $loanId = $loanResponse->json('data.id');

        $this->deleteJson('/api/loans/' . $loanId)
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'stock' => 1,
        ]);
    }

    public function test_it_returns_ai_recommendation_payload(): void
    {
        $book = Book::create([
            'title' => 'Atomic Habits',
            'author' => 'James Clear',
            'year' => 2018,
            'stock' => 4,
        ]);

        Loan::create([
            'book_id' => $book->id,
            'borrower_name' => 'Raka',
            'borrow_date' => '2026-04-28',
            'return_date' => '2026-05-05',
        ]);

        $mock = Mockery::mock(GroqService::class);
        $mock->shouldReceive('recommendLibrary')
            ->once()
            ->andReturn([
                'success' => true,
                'content' => 'Rekomendasi: tingkatkan stok buku populer.',
                'status' => 200,
                'data' => [],
            ]);

        $this->app->instance(GroqService::class, $mock);

        $this->postJson('/api/ai/recommendation')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.recommendation', 'Rekomendasi: tingkatkan stok buku populer.');
    }

    public function test_it_returns_ai_error_when_service_fails(): void
    {
        $mock = Mockery::mock(GroqService::class);
        $mock->shouldReceive('recommendLibrary')
            ->once()
            ->andReturn([
                'success' => false,
                'status' => 500,
                'error' => 'GROQ_API_KEY belum dikonfigurasi.',
            ]);

        $this->app->instance(GroqService::class, $mock);

        $this->postJson('/api/ai/recommendation')
            ->assertStatus(500)
            ->assertJsonPath('success', false)
            ->assertJsonPath('data.error', 'GROQ_API_KEY belum dikonfigurasi.');
    }
}
