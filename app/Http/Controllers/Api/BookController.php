<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index' , 'show']]);
    }
    
    public function index()
    {
        $books = BookResource::collection(Book::latest()->get());
        return responseJson(1 , 'success' , $books);
    }

    public function store(BookRequest $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        $book = Book::create($request->all());

        return responseJson(1 , 'Book is stored successfully' , new BookResource($book) );
    }

    public function show(Book $book)
    {
        return responseJson(1 , 'success' , new BookResource($book) );      
    }

    public function update(BookRequest $request, Book $book)
    {
        if($book->user_id != auth()->user()->id)
        {
            return responseJson(0 , 'book is not belonging to you!!');
        }
        $book->update($request->except('user_id'));     
        return responseJson(1 , 'Book is updated successfully' , new BookResource($book) );
    }

    public function destroy(Book $book)
    {
        if($book->user_id != auth()->user()->id)
        {
            return responseJson(0 , 'book is not belonging to you!!');
        }
        $book->delete();     
        return responseJson(1 , 'Book is Deleted Successfully' );
    }
}
