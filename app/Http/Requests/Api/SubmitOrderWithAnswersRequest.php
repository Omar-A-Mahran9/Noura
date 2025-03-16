<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class SubmitOrderWithAnswersRequest extends FormRequest
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
            'consultaion_type_id' => 'required|exists:consultaion_type,id',
            'consultaion_id' => 'required|exists:consultaion,id',
            'consultaion_schedual_id' => 'nullable|exists:consultaion_schedual,id',
            'vendor_id' => 'required|exists:vendors,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'type' => 'required|in:book,course,consultation',
            'total_price' => 'required|numeric|min:1',
            'payment_status' => 'required|in:pending,paid,failed',
            'payment_method' => 'nullable|in:visa,mastercard,mada',

            // Answers validation
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|exists:quezies_questions,id',
            'answers.*.answer_id' => 'required|exists:quezies_answers,id',
        ];
    }
}
