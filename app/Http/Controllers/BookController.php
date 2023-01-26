<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Requests\BookStoreRequest;
use App\Http\Requests\BookListStoreRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderBy('id')
            ->with('genre')
            ->get();
        return BookResource::collection($books);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function favoriteBooks()
    {
        $user = Auth::user();
        $books = $user->books;
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookStoreRequest $request)
    {
        $book = Book::create($request->all());
        return $book;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function addFavorite(Book $book)
    {
        $user = Auth::user();
        $user->books()->save($book);
        return response()->json(["message" => "Books added to favorites"], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeBookList(BookListStoreRequest $request)
    {
        Book::insert($request->all());
        return response()->json(["message" => "Books created"], Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(["message" => "Book deleted"], Response::HTTP_OK);
    }
}