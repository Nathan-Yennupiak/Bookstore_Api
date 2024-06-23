<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Get all books
    public function index()
    {
        return Book::all();
    }

    // Show the form for creating a new book
    public function create()
    {
        //
    }

    // Add/Create a new book
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        return response()->json($book, 201); // 201 Created
    }

    // Get a book by ID
    public function show($id)
    {
        $book = Book::find($id);
        if (!$book) {

            $notfound = "Book with ID: $id not found";

            return response()->json(['message' => $notfound], 404); // 404 Not Found
        }

        return response()->json($book, 200); // 200 OK
    }

    // Show the form for editing a book
    public function edit($id)
    {
        //
    }

    // Update a book
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {

            $notfound = "Book with ID: $id not found";

            return response()->json(['message' => $notfound], 404); // 404 Not Found
        }
        $book->update($request->all());
        return response()->json($book, 200); // 200 OK
    }

    // Delete a book
    public function destroy($id)
    {
        $book = Book::find($id);
        if (!$book) {

            $notfound = "Book with ID: $id not found";

            return response()->json(['message' => $notfound], 404); // 404 Not Found
        }
        $book->delete();
        return response()->json(['message' => "Book with ID: $id deleted successfully!"], 200); // 200 OK
    }
}
