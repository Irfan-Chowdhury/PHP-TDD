<?php

namespace Tests\Unit;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function testOnlyNameIsRequiredToCreateAnAuthor(): void
    {
        Author::firstOrCreate([
            'name'=>'Irfan Chy',
        ]);

        $this->assertCount(1, Author::all());
    }
}
