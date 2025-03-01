<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_articles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return [
            'title_ar'        => ['required', 'string', 'max:255', 'unique:articles,title_ar', new NotNumbersOnly()],
            'title_en'        => ['required', 'string', 'max:255', 'unique:articles,title_en', new NotNumbersOnly()],
            'description_ar'  => ['required', 'string'],
            'description_en'  => ['required', 'string'],
            'main_image'      => ['required', 'mimes:jpeg,png,jpg,webp,svg', 'max:522'],
            'category_id'     => ['required', 'array'], // Ensures it's an array
            'category_id.*'   => ['exists:categories,id'], // Ensures each selected ID exists in the `categories` table
        ];
    }
}