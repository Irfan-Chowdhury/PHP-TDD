<?php

namespace Tests\Feature;

use App\Models\Author;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    public function testAuthorCanBeCreated()
    {
        $this->withoutExceptionHandling();

        $dt = '05/14/1988';
        $date = Carbon::parse($dt);

        $this->post('/author',[
            'name' => 'Author Name',
            'dob' => $date,
        ]);

        $author = Author::all();

        $this->assertCount(1, $author);
        $this->assertInstanceOf(Carbon::class, $date);
        // $this->assertEquals('1988/14/04', Carbon::parse($author->first()->dob)->format('Y/d/m'));
        $this->assertEquals('1988/14/05', Carbon::parse($author->first()->dob)->format('Y/d/m'));

    }
}
