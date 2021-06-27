<?php

namespace Tests\Feature;

use App\Models\Author;
use Tests\TestCase;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books', Book::factory()->make()->toArray());

        $book = Book::first();
        $this->assertDatabaseCount('books', 1);
        $response->assertRedirect($book->path);
    }
    
    /** @test */
    public function a_title_is_required()
    {
        $response = $this->post('/books', Book::factory()->noTitle()->make()->toArray());

        $response->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function an_author_is_required()
    {
        $response = $this->post('/books', Book::factory()->noAuthorId()->make()->toArray());

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        $this->post('/books', Book::factory()->make()->toArray());
        $book = Book::first();


        $newAuthorId = Author::factory()->create()->id;
        $response = $this->patch($book->path, [
            'title' => 'New Title',
            'author_id' => $newAuthorId
        ]);
        $this->assertDatabaseHas('books', [
            'title' => 'New Title',
            'author_id' => $newAuthorId
        ]);
        $response->assertRedirect($book->fresh()->path);
    }

    /** @test */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', Book::factory()->make()->toArray());
        $this->assertDatabaseCount('books', 1);

        $book = Book::first();
        
        $response = $this->delete('/books/' . $book->id);
        $this->assertDeleted($book);
        $response->assertRedirect('/books');
    }

    /** @test */
    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();
        $this->post('/books', Book::factory()->make()->toArray());

        $book = Book::first();
        $author = Author::first();

        $this->assertDatabaseCount('authors', 1);
        $this->assertEquals($author->id, $book->author->id);
    }
}
