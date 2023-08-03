<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testABookCanBeAddedToTheLibrary(): void
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Irfan',
        ]);

        $book = Book::first();


        // $response->assertOk();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());

    }

    public function testATitleIsRequired() : void
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Irfan',
        ]);

        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired() : void
    {
        // $this->withoutExceptionHandling();
        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => '',
        ]);

        $response->assertSessionHasErrors('author');
    }
    public function testBookCanBeUpdated() : void
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author',
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals('New Author',Book::first()->author);

        $response->assertRedirect($book->fresh()->path()); //note

    }

    public function testABookCanBeDeleted() : void
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor',
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());


        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');


    }
}
