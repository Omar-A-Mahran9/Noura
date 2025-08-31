<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_course_category');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
 
public function rules()
{
    $categoryId = $this->route('coursecategory'); // from resource route

    return [
        'name_ar' => [
            'required',
            'string',
            new NotNumbersOnly(),
            Rule::unique('coursecategories', 'name_ar')->ignore($categoryId),
        ],
        'name_en' => [
            'required',
            'string',
            'max:255',
            new NotNumbersOnly(),
            Rule::unique('coursecategories', 'name_en')->ignore($categoryId),
        ],
    ];
}

}
