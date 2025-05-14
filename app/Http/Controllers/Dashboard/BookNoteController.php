<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreBooksRequest;
use App\Http\Requests\Dashboard\UpdateBooksRequest;
use App\Models\Book;
use App\Models\BookImage;
use App\Models\BookNote;
use App\Models\Course;
use App\Models\Employee;
use Illuminate\Http\Request;

class BookNoteController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_books_notes');

        if ($request->ajax())
        {
            $data = getModelData(model: new BookNote(),relations: ['Books' => ['id', 'title']]);

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
        $this->authorize('create_books');
        $employees = Employee::where('type','author')->get(); // Assuming you want to fetch all employees
        $courses=Course::select('id','name_' . getLocale())->get();

        return view('dashboard.books.create',compact('employees','courses'));
    }


    public function store(StoreBooksRequest $request)
    {

        // Authorize the user to create books
        $this->authorize('create_books');

        // Get the validated data
        $data = $request->validated();
        unset($data['images']);
        unset($data['courses_ids']); // Remove category_id from $data

        // Handle the main image upload
        if ($request->file('main_image')) {
            $data['main_image'] = uploadImage($request->file('main_image'), "books");
        }
        if ($request->file('pdf_path')) {
            $data['pdf_path'] = uploadImage($request->file('pdf_path'), "books/pdf/");
        }

        // Create the book record
        $book = Book::create($data);
        if ($book) {
            // Sync the categories from the request data
            // Ensure category_id is passed as an array
            $book->courses()->sync($request->courses_ids);
        }
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
