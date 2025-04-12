<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBooksRequest extends FormRequest
{
    /**UpdateLivesRequest
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_books');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $book = request()->route('book');

        return [
            'title_ar'    => ['required' , 'string' , 'max:255' , 'unique:books,title_ar,'.$book->id,new NotNumbersOnly()],
            'title_en'    => ['required' , 'string' , 'max:255' , 'unique:books,title_en,'.$book->id,new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'price' => ['required', 'string'],
            'main_image'      => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048' ,
            'stock' => ['required', 'numeric'],
            'pdf_path' => 'required|mimes:pdf',
            'images'    => [ 'array'], // Ensure it is an array
            'images.*'  => ['mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // Validate each file
        ];
    }
}
