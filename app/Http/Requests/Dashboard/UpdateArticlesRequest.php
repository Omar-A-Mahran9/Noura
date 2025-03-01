<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArticlesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_articles');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $article = request()->route('article');
 
        return [
            'title_ar'    => ['required' , 'string' , 'max:255' , 'unique:articles,title_ar,'.$article->id,new NotNumbersOnly()],
            'title_en'    => ['required' , 'string' , 'max:255' , 'unique:articles,title_en,'.$article->id,new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'main_image'      => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048' , 
            'category_id'     => ['required', 'array'], // Ensures it's an array
            'category_id.*'   => ['exists:categories,id'], // Ensures each selected ID exists in the `categories` table
        ];
    }
}
