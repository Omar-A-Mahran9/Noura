<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreBooksRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_books');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar'    => ['required' , 'string' , 'max:255' , 'unique:books,title_ar',new NotNumbersOnly()],
            'title_en'    => ['required' , 'string' , 'max:255' , 'unique:books,title_en',new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'numeric'],
            'pdf_path' => 'required|mimes:pdf',
            "assign_to"      => [ 'required', 'string' ], // Add type validation

            'images'    => ['required', 'array'], // Ensure it is an array
            'images.*'  => ['mimes:jpeg,png,jpg,webp,svg', 'max:2048'], // Validate each file
            'main_image'      => 'required|mimes:jpeg,png,jpg,webp,svg|max:2048'];
          
    }
}
