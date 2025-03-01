<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_consultation_time');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title_ar'        => ['required', 'string', 'max:255', 'unique:books,title_ar', new NotNumbersOnly()],
            'title_en'        => ['required', 'string', 'max:255', 'unique:books,title_en', new NotNumbersOnly()],
            'description_ar'  => ['required', 'string'],
            'description_en'  => ['required', 'string'],
            'consultaion_type_id'  => ['required'],
            'price'           => ['required', 'numeric'],
            'time_list'       => ['required', 'array'], // Ensure it's an array
            'time_list.*.date'=> ['required', 'date', 'after_or_equal:today'], // Validate each date
            'time_list.*.time'=> ['required', 'date_format:H:i'], // Validate each time
            // 'available' => ['required', 'boolean'],
            'main_image'      => ['required', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
        ];
    }
}
