<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends ApiController
{
    //Add Book
    public function AddBook(Request $request){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
        try{
            $add_book = Book::create([
                'book_code'=>$request->bookCode,
                'title'=>$request->title,
                'subject'=>$request->subject,
                'author_name'=>$request->authorName,
                'release_date'=>$request->releaseDate,
                'details'=>$request->details,
            ]);
            $message= 'Book added successfully.';
            return $this->sendResponse(new BookResource($add_book),$message);
        }catch(\Exception $e){
            $message='An error occurred during the add process.';
            return $this->sendError($message);
        }
        }
        return response()->json(['success'=>false]);
    }
    //Update Book
    public function updateBook(Request $request,$id){
        $user = auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try{
                $update_book=Book::where('id',$id)->update([
                    'book_code'=>$request->bookCode,
                    'title'=>$request->title,
                    'subject'=>$request->subject,
                    'author_name'=>$request->authorName,
                    'release_date'=>$request->releaseDate,
                    'details'=>$request->details,
                ]);
                $message='Book updated successfully.';
                return $this->sendResponse($update_book,$message);
            }catch(\Exception $e){
                $message='Book could not be updated.';
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
    //Delete Book
    public function deleteBook($id){
        $user= auth()->user();
        if($user->tokenCan('Admin') || $user->tokenCan('Personal')){
            try {
                $book_find = Book::find($id);
                $delete_book = $book_find->delete();
                $message = "Book Deleted.";
                return $this->sendResponse($delete_book, $message);
            } catch (\Exception $e) {
                $message = "Something went wrong.";
                return $this->sendError($message);
            }
        }
        return response()->json(['success'=>false]);
    }
    //Get All Book
    public function getAllBook(){
        $book=Book::select(
            'book_code as bookCode','title','subject',
            'author_name as authorName','release_date as releaseDate','details'
        )->get();
        $message ='Book';
        return $this->sendResponse($book,$message);
    }
}
