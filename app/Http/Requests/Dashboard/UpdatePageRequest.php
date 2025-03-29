<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
         return [

            'sections' => ['required', 'array'],
            'sections.*.id' => ['nullable', 'exists:sections_page,id'],
            'sections.*.title' => ['required', 'string', 'max:255'],
            'sections.*.description' => ['nullable', 'string'],
            'sections.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2MB max

            'sections.*.items' => ['nullable', 'array'],
            'sections.*.items.*.id' => ['nullable', 'exists:section_items,id'],
            'sections.*.items.*.title' => ['required', 'string', 'max:255'],
            'sections.*.items.*.description' => ['nullable', 'string'],
            'sections.*.items.*.image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], // 2MB max
        ];
    }
}
