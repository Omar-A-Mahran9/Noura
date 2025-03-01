<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            '_token'       => 'required|string',
            'type'         => ['required', Rule::in(['text', 'single', 'multiple', 'true_false'])], // Allowed types
            'is_main'      => 'nullable|boolean', // Must be 1 or 0
            'quiz_id'      => 'required|exists:quizzes,id', // Ensure quiz exists
            'name_ar'      => 'required|string|max:255',
            'name_en'      => 'required|string|max:255',
        ] + $this->answerRules(); // Merge conditional answer ruless
    }

    protected function answerRules(): array
    {
        if (in_array($this->input('type'), ['single', 'multiple'])) {
            return [
                'answer_list' => 'required|array|min:1', // At least one answer is required
                'answer_list.*.name_ar' => 'required|string|max:255', // Validate Arabic answer
                'answer_list.*.name_en' => 'required|string|max:255', // Validate English answer
            ];
        }

        return [];
    }
}
