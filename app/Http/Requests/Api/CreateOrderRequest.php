<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
            'vendor_id' => 'nullable|exists:vendors,id',
            'book_id' => 'nullable|exists:books,id',
            'course_id' => 'nullable|exists:courses,id',
            'consultation_id' => 'nullable|exists:consultaion,id',
            'payment_method' => 'required|in:visa,mastercard,mada',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->book_id && !$this->course_id && !$this->consultation_id) {
                $validator->errors()->add('order', 'At least one of book_id, course_id, or consultation_id must be provided.');
            }
        });
    }
}
