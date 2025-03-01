<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_attachment_materials');
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
            'description_ar'    => 'required | string',
            'description_en'    => 'required | string',
            'course_id'       => 'required',
            'section_id'       => 'required',
            'file_path' => 'required|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,docx',
            'type'         => 'required' ,
        ];
    }
}
