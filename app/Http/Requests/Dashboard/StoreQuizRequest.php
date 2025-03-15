<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_quizzes');
    }

    /**create_quizzes
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'    => ['required' , 'string' , 'max:255'  ,new NotNumbersOnly()],
            'name_en'    => ['required' , 'string' , 'max:255' ,new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'duration'       => 'required',
            // 'consultaion_id' => 'required|numeric|exists:consultaion,id',
            'open'       => '',

        ];

}
}
