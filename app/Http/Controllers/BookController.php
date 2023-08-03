<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
class BookController extends Controller
{
    public function store(Request $request)
    {
        $book = Book::create($this->validatedRequest());
        return redirect($book->path());

    }

    public function update(Book $book)
    {
        $book->update($this->validatedRequest());

        return redirect($book->path());
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }

    protected function validatedRequest()
    {
        return request()->validate([
            'title' => 'required',
            'author' => 'required',
        ]);
    }
}
