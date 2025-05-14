<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreBooksNoteRequest;
use App\Http\Requests\Dashboard\StoreBooksRequest;
use App\Http\Requests\Dashboard\UpdateBooksRequest;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\BookNote;
use App\Models\Course;
use App\Models\Employee;
use App\Models\Vendor;
use Illuminate\Http\Request;

class BookNoteController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_books_notes');

        if ($request->ajax())
        {
            $data = getModelData(model: new BookNote(),relations: ['book' => ['id', 'title_ar','title_en', 'description_ar','description_en']]);

             return response()->json($data);
        }

        return view('dashboard.booksnotes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_books_notes');

        $books = Book::select('id', 'title_en')->get();
        $vendors = Vendor::select('id', 'name')->get(); // ← Add this line

        return view('dashboard.booksnotes.create', compact('books', 'vendors'));
    }

public function store(StoreBooksNoteRequest $request)
{
    $this->authorize('create_books_notes');

    $data = $request->validated();

    $note = [
        'book_id'   => $data['book_id'],
        'vendor_id' => $data['vendor_id'],
        'page'      => $data['page'],
        'text'      => $data['text'],
        'note'      => $data['note'] ?? null,
        'question'  => $data['question'] ?? null,
        'answer'    => $data['answer'] ?? null,
        'is_answer' => !empty($data['answer']),
    ];

    BookNote::create($note);

    return redirect()->route('dashboard.books_notes.index')
        ->with('success', __('Book note added successfully.'));
}

    public function removeImage($id)
    {

         $image = BookImage::findOrFail($id);

        // Delete the image file
        deleteImage($image->image, 'Books/images');

        // Delete the image record from the database
        $image->delete();
     }

     public function show(Book $book)
     {
         $this->authorize('show_books');
         return view('dashboard.books.show',compact('book'));
     }


    public function edit(Book $book)
    {
        $this->authorize('update_books');
        $courses=Course::select('id','name_' . getLocale())->get();

        return view('dashboard.books.edit',compact('book','courses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBooksRequest $request, Book $book)
    {

        $this->authorize('update_books');

        $data=$request->validated();
        unset($data['images']);
        // Handle the main image upload
        if ($request->file('main_image')) {
            deleteImage($book->main_image , 'books' );
            $data['main_image'] = uploadImage($request->file('main_image'), "books");
        }
        if ($request->file('pdf_path')) {
            deleteImage($book->main_image , 'books/pdf/' );

            $data['pdf_path'] = uploadImage($request->file('pdf_path'), "books/pdf/");
        }

        $book->update($data);

                // Handle additional images (more_images)
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $file) {
                        // Upload each image
                        $imagePath = uploadImage($file, "books/images");

                        // Create a BookImage record
                        BookImage::create([
                            'book_id' => $book->id,  // Associate image with the created book
                            'image' => $imagePath,    // Store the image path
                        ]);
                    }
                }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Book $book)
    {

        $this->authorize('delete_books');

        if($request->ajax())
        {
            $book->delete();
            deleteImage($book->main_image , 'books' );
        }
    }
}
