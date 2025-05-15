<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreBooksNoteRequest;
use App\Http\Requests\Dashboard\StoreBooksRequest;
use App\Http\Requests\Dashboard\UpdateBooksNoteRequest;
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
            $data = getModelData(model: new BookNote(),where: [
        ['note', '!=', null],
            ],relations: ['book' => ['id', 'title_ar','title_en', 'description_ar','description_en']]);

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


    }
    public function update(UpdateBooksNoteRequest $request,$id)
    {
        $this->authorize('update_books_notes');
            $BookNote = BookNote::findOrFail($id);

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

        $BookNote->update($note);

    }






    public function edit($id)
    {
        $note = BookNote::findOrFail($id);
        $books = Book::all();
        $vendors = Vendor::all();

        return view('dashboard.booksnotes.edit', compact('note', 'books', 'vendors'));
    }


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
