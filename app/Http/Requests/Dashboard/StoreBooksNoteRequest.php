<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreBooksNoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_books_notes');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
     return [
        'book_id'   => 'required|exists:books,id',
        'vendor_id' => 'required|exists:vendors,id',
        'page'      => 'required|integer|min:1',
        'text'      => 'required|string',

        'note'      => 'nullable|string',
        'question'  => 'nullable|string',
        'answer'    => 'nullable|string',
        ];
    }
}
