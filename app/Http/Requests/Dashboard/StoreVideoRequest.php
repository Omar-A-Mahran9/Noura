<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreVideoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_videos_materials');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_ar'         => 'required|string|max:255' ,
            'name_en'         => 'required|string|max:255' ,
            'course_id'       => 'required',
            'section_id'       => 'required',
            'video_path'         => 'required|url' ,
            'type'         => 'required' ,
        ];
    }
}
