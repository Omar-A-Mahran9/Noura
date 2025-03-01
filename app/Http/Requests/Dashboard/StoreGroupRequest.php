<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        return abilities()->contains('create_categories');
     }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image'      => 'required|mimes:jpeg,png,jpg,webp,svg|max:2048' ,
            'name_ar' => ['required','string',new NotNumbersOnly()],
            'name_en'         =>['required','string',new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],

        ];
    }
}
