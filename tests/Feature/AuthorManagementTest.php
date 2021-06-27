<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->post('/authors', Author::factory()->make()->toArray());
        $author = Author::all();
        $this->assertDatabaseCount('authors', 1);
        $this->assertInstanceOf(Carbon::class, $author->first()->dob);
    }
}
