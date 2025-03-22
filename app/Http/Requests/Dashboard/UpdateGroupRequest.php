<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_categories');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category = request()->route('category');

        return [
            'name_ar' => ['required','string',new NotNumbersOnly()],
            'name_en'         => ["required", "string", "max:255",new NotNumbersOnly()],
            'image'      => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048' ,
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
        ];
    }
}
