<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultationTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_consultation_type');

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $category = request()->route('consultation_type');
 
        return [
            'name_ar' => ['required','string',new NotNumbersOnly()],
            'name_en'         => ["required", "string", "max:255",new NotNumbersOnly()],
        ];
    }
}
