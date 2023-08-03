<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

#php artisan test --filter=testAuthorIsRequired

class BookManagementTest extends TestCase
{
    use RefreshDatabase;



    public function testABookCanBeAddedToTheLibrary(): void
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());
        $book = Book::first();
        $this->assertCount(1, Book::all());

        $response->assertRedirect($book->path());

    }

    public function testATitleIsRequired() : void
    {
        // $this->withoutExceptionHandling();

        // $response = $this->post('/books', [
        //     'title' => '',
        //     'author' => 'Irfan',
        // ]);
        $response = $this->post('/books', array_merge($this->data(), ['title' =>'']));
        $response->assertSessionHasErrors('title');
    }

    public function testAuthorIsRequired() : void
    {
        // $this->withoutExceptionHandling();
        // $response = $this->post('/books', [
        //     'title' => 'Cool Book Title',
        //     'author' => '',
        // ]);
        $response = $this->post('/books', array_merge($this->data(), ['author_id' =>'']));
        $response->assertSessionHasErrors('author_id');
    }
    public function testBookCanBeUpdated() : void
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author_id' => 'New Author',
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals(3,Book::first()->author_id);

        $response->assertRedirect($book->fresh()->path()); //note

    }

    public function testABookCanBeDeleted() : void
    {
        // $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();
        $this->assertCount(1, Book::all());


        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());

        $response->assertRedirect('/books');
    }

    public function testANewAuthorIsAutomaticallyAdded()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Title',
            'author_id' => 'Victor',
        ]);

        $book = Book::first();
        $author = Author::first();

        $this->assertEquals($author->id, $book->author_id);
        $this->assertCount(1, Author::all());
    }

    private function data():array
    {
        return [
            'title' => 'Cool Book Title',
            'author_id' => 'Irfan',
        ];
    }
}
