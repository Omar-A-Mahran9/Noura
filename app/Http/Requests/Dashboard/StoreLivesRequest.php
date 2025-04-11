<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreLivesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_live');
    }

    public function rules()
    {
        return [
            'title_ar' => ['required', 'string', 'max:255', 'unique:lives,title_ar', new NotNumbersOnly()],
            'title_en' => ['required', 'string', 'max:255', 'unique:lives,title_en', new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'price' => ['required', 'numeric'],
            'assign_to' => ['required', 'string'],
            'main_image' => ['required', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'video_url' => ['required', 'url', 'string', 'max:255'],
            'day_date' => ['required', 'date'],
            'from' => ['required', 'date_format:H:i'],
            'to' => ['required', 'date_format:H:i', 'after:from'],
        ];
    }

}
