<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BookResources;
use App\Http\Resources\Api\ConsultationResources;
use App\Http\Resources\ConsultationResources as ResourcesConsultationResources;
use App\Models\Book;
use App\Models\BookComment;
use App\Models\BookNote;
use App\Models\Consultaion;
use App\Models\ConsultaionSchedual;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request  ;

class BooksController extends Controller
{

    public function index()
    {
        // Fetch all books
        $Best_Seller = Book::where('stock', '>', 0)
        ->latest() // Orders by 'created_at' in descending order
        ->take(3) // Limits the result to 5
        ->get();
        $books = Book::where('stock', '>', 0)
        ->latest() // Orders by 'created_at' in descending order
        ->get();


        // Return the response using the success response format
        return $this->success(data:[
            'Best_Seller' => BookResources::collection($Best_Seller),
            'author'=>"",
            'books' => BookResources::collection($books),
        ]);
    }


    public function single($id)
    {
        // Retrieve the single article with its related comments and vendor data
        $book = Book::where('id', $id)
            // ->with('comments', 'comments.vendor')
            ->first();

        // If the article does not exist, return a 404 response
        if (!$book) {
            return $this->failure("Bookk not found");

        }

        // Use the singular ArticleResource to transform the single article
        $data = BookResources::make($book); // Use make() to transform a single resource

        // Return the transformed article data
        return $this->success(
            message: "Single Book",
            data: $data
        );
    }

    public function createCommentes(Request $request)
    {
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'comment' => 'required|string|max:500',
            'rate' => 'required|numeric|min:1|max:5', // Correct rule for numeric validation
        ]);

       if(Auth::guard('vendor')->user()){
           if(Auth::guard('vendor')->user()->status != 2){
           if(Auth::guard('vendor')->user()->status==1){
                 return $this->validationFailure(errors:['message'=>__('this account is pending please wait for admin approval')]);
           }
           elseif(Auth::guard('vendor')->user()->status==0){
               return $this->validationFailure(errors:['message'=>__('this account is blocekd please contact with admin')]);
           }
           elseif(Auth::guard('vendor')->user()->status==3){
               return $this->validationFailure(errors:['message'=>__('this account is rejected please create new account or contact with admin')]);
           }

       }
       else{
           $comment=BookComment::create([
               'vendor_id' => Auth::guard('vendor')->user()->id,
               'book_id' => $data['book_id'],
               'rate' => $data['book_id'],
               'description_ar' => request('comment'),
               'description_en' => request('comment'),

               ]);
           return $this->success(data:$comment);
     }
   } else{
       return $this->validationFailure(errors:['message'=>__('must be login to create comment')]);

   }
   }


   public function comments($book_id)
   {
       // Fetch paginated comments for the given article ID
       $comments = BookComment::where('book_id', $book_id)->paginate(3);

       // Transform the data to include only required fields
       $transformedComments = $comments->through(function ($comment) {
           return [
               'id' => $comment->id,
               'description' => $comment->description,
               'rate' => $comment->rate ?? null,

               'client' => $comment->vendor->name,
               'client_image' => getImagePathFromDirectory($comment->vendor->image, 'ProfileImages'),
               'created_at' => $comment->created_at->format('Y-m-d'),
           ];
       });

       return $this->successWithPagination('Comments retrieved successfully', $transformedComments);
   }

   public function notes($book_id)
   {
       // Fetch paginated book notes for the given book ID
       $notes = BookNote::with('vendor') // eager load vendor if relationship exists
           ->where('book_id', $book_id)
           ->paginate(10);

       // Transform the data
       $transformed = $notes->through(function ($note) {
           return [
               'id' => $note->id,
               'main_text' => $note->text,
               'note' => $note->note,
               'question' => $note->question,
               'answer' => $note->answer,
               'is_answer' => $note->is_answer,

               'created_at' => $note->created_at->format('Y-m-d'),
           ];
       });

       return $this->successWithPagination('Notes retrieved successfully', $transformed);
   }


   public function noteStore(Request $request)
{
    $validated = $request->validate([
        'book_id' => 'required|exists:books,id',
        'page' => 'required|integer',
        'text' => 'required|string',
        'note' => 'required_without:question|string|nullable',
        'question' => 'required_without:note|string|nullable',
    ]);

    $note = BookNote::create($validated);

    return $this->success('Book note created successfully', [
        'id' => $note->id,
        'page' => $note->page,
        'note' => $note->note,
        'text' => $note->text,
        'question' => $note->question,
        'created_at' => $note->created_at->format('Y-m-d'),
    ]);
}

}
