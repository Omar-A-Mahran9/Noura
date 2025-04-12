<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLivesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_live');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Getting the live event model from the route
        $live = $this->route('live');

        return [
            'title_ar'          => ['required', 'string', 'max:255'  , new NotNumbersOnly()],
            'title_en'          => ['required', 'string', 'max:255', new NotNumbersOnly()],
            'description_ar'    => ['required', 'string'],
            'description_en'    => ['required', 'string'],
            'price'             => ['required', 'string'],
            'main_image'        => 'nullable|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'assign_to'         => ['required', 'exists:employees,id'], // Assuming the employee is from the 'employees' table
            'day_date'          => ['required', 'date'],
            'from'              => ['required', 'date_format:H:i'],
            'to'                => ['required', 'date_format:H:i'],
            'video_url'         => ['nullable', 'url'],
         ];
    }
}
