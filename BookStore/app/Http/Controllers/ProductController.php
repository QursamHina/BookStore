<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json(['books' => $books]);
    }

    public function getBookDetails($id)
    {
        // Fetch the book details by its ID from the database
        $book = Book::find($id);
        // Check if the book exists
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
        return response()->json(['book' => $book]);
    }
    public function createBookReview(Request $request, $id)
    {
        // Validate user input for creating a review
        $this->validate($request, [
            'content' => 'required|string',
            'book_id' => 'required',
        ]);
    
        // Find the book by ID
        $book = Book::find($id);
    
        // Check if the book exists
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    
        // Create a new review
        $review = new Product([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id, // Assuming you have authentication in place
        ]);
    
        // Save the review to the book's reviews relationship
        $book->reviews()->save($review);
    
        return response()->json(['message' => 'Review created successfully']);
    }
    
    public function createBookRating(Request $request, $id)
    {
        // Validate user input for creating a rating
        $this->validate($request, [
            'rating' => 'required|integer|between:1,5',
        ]);
    
        // Find the book by ID
        $book = Book::find($id);
    
        // Check if the book exists
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    
        // Create a new rating
        $rating = new Product([
            'rating' => $request->input('rating'),
            'user_id' => auth()->user()->id, // Assuming you have authentication in place
        ]);
    
        // Save the rating to the book's ratings relationship
        $book->ratings()->save($rating);
    
        return response()->json(['message' => 'Rating created successfully']);
    }
    public function getBookReviews($id)
    {
        // Fetch the book reviews by book ID from the database
        $book = Book::find($id);

        // Check if the book exists
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        // Fetch the reviews associated with the book
        $reviews = $book->reviews;

        return response()->json(['reviews' => $reviews]);
    }

    public function getBookRatings($id)
    {
        // Fetch the book ratings by book ID from the database
        $book = Book::find($id);

        // Check if the book exists
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }

        // Fetch the ratings associated with the book
        $ratings = $book->ratings;

        return response()->json(['ratings' => $ratings]);
    }

    

}
