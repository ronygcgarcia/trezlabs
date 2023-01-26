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
    /**
     * @OA\Get(
     *   tags={"Book"},
     *   path="/books",    
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *       response=200,
     *       description="List of books",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(    
     *               type="array",          
     *               @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         description="Book id",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="description",
     *                         description="Book description",
     *                         type="string",
     *                         example="Description"
     *                    ),
     *                    @OA\Property(
     *                         property="genre_id",
     *                         description="Id of book genre",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="genre",
     *                         description="Book genre name",
     *                         type="string",
     *                         example="Genre"
     *                    ),
     *               ),
     *          ),
     *      ),
     *   ),
     * ),
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
    /**
     * @OA\Get(
     *   tags={"Book"},
     *   path="/books/favorites",    
     *   security={{"bearerAuth":{}}},
     *   @OA\Response(
     *       response=200,
     *       description="List of favorite books",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(    
     *               type="array",          
     *               @OA\Items(
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         description="Book id",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="description",
     *                         description="Book description",
     *                         type="string",
     *                         example="Description"
     *                    ),
     *                    @OA\Property(
     *                         property="genre_id",
     *                         description="Id of book genre",
     *                         type="integer",
     *                         example=1
     *                    ),
     *               ),
     *          ),
     *      ),
     *   ),
     * ),
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
    /**
     * @OA\Post(
     *   tags={"Book"},
     *   path="/books",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="title",
     *                  description="Book title",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="description",
     *                  description="Book description",
     *                  type="string",
     *              ),
     *              @OA\Property(
     *                  property="genre_id",
     *                  description="Book genre id",
     *                  type="integer",
     *              ),
     *          ),
     *      ),
     *  ),
     *   @OA\Response(
     *       response=201,
     *       description="Book created",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *                     @OA\Property(
     *                         property="id",
     *                         description="Book id",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="description",
     *                         description="Book description",
     *                         type="string",
     *                         example="Description"
     *                    ),
     *                    @OA\Property(
     *                         property="genre_id",
     *                         description="Id of book genre",
     *                         type="integer",
     *                         example=1
     *                    ),
     *                    @OA\Property(
     *                         property="updated_at",
     *                         description="Date of update",
     *                         type="string",
     *                         example="2023-01-26T02:29:13.000000Z"
     *                    ),
     *                    @OA\Property(
     *                         property="created_at",
     *                         description="Date of creation",
     *                         type="string",
     *                         example="2023-01-26T02:29:13.000000Z"
     *                    ),
     *          ),
     *      ),
     *   )
     * )
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
    /**
     * @OA\Post(
     *   tags={"Book"},
     *   path="/books/{book_id}/favorite",
     *   security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="book_id",
     *         description="Book id to add to favorite list",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ) 
     *     ),  
     *   @OA\Response(
     *       response=200,
     *       description="Returns success message",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         description="Success message",
     *                         type="string",
     *                         example="Books added to favorites"
     *                    ),                  
     *          ),
     *      ),
     *   )
     * )
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
    /**
     * @OA\Post(
     *   tags={"Book"},
     *   path="/books/list",
     *   security={{"bearerAuth":{}}},
     *   @OA\RequestBody(
     *      required=true,
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(    
     *               type="array",          
     *               @OA\Items(
     *                     type="object",
     *                    @OA\Property(
     *                         property="title",
     *                         description="Book title",
     *                         type="string",
     *                         example="Title"
     *                    ),
     *                    @OA\Property(
     *                         property="description",
     *                         description="Book description",
     *                         type="string",
     *                         example="Description"
     *                    ),
     *                    @OA\Property(
     *                         property="genre_id",
     *                         description="Id of book genre",
     *                         type="integer",
     *                         example=1
     *                    ),
     *               ),
     *          ),
     *      ),
     *  ),
     *   @OA\Response(
     *       response=201,
     *       description="User logged",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         description="Success message",
     *                         type="string",
     *                         example="Books created"
     *                    ),     
     *          ),
     *      ),
     *   )
     * )
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
    /**
     * @OA\Delete(
     *   tags={"Book"},
     *   path="/books/{book_id}",
     *   security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="book_id",
     *         description="Book id to delete",
     *         in = "path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer"
     *         ) 
     *     ),  
     *   @OA\Response(
     *       response=200,
     *       description="Returns success message",
     *      @OA\MediaType(
     *          mediaType="application/json",
     *          @OA\Schema(
     *                     @OA\Property(
     *                         property="message",
     *                         description="Success message",
     *                         type="string",
     *                         example="Book deleted"
     *                    ),                  
     *          ),
     *      ),
     *   )
     * )
     */
    public function destroy(Book $book)
    {
        $favorite = $book->users;
        error_log(!count($favorite));

        if(count($favorite)) {
            return response()->json([
                'message' => "It is not possible to delete this book as it is associated with another record"
            ], Response::HTTP_BAD_REQUEST);
        }
        $book->delete();
        return response()->json(["message" => "Book deleted"], Response::HTTP_OK);
    }
}