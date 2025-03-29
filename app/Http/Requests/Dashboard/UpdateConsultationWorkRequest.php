<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConsultationWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'steps' => 'required|array|min:1', // Ensure steps is an array and has at least 1 step
            'steps.*.name' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
            'steps.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
