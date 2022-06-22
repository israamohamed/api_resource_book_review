<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Book;
use App\Http\Resources\RatingResource;
use App\Http\Requests\RatingRequest;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    public function store( Book $book, RatingRequest $request)
    {
      $rating = Rating::firstOrCreate(
        [
          'user_id' => $request->user()->id,
          'book_id' => $book->id,
        ],
        [
            'rate' => $request->rate,
            'body' => $request->body,
        ]
      );

      return responseJson(1 , 'Rate is added successfully' ,  new RatingResource($rating));
    }
}
