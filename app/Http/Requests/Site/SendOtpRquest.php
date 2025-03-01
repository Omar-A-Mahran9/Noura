<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class SendOtpRquest extends FormRequest
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
            'phone' => ['required_without:email', 'string', 'regex:/^((\+|00)966|0)?5[0-9]{8}$/'],
            'email' => ['required_without:phone', 'email', 'max:255'],        ];
    }
}
