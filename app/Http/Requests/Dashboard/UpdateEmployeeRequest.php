<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\NotNumbersOnly;
use App\Rules\PasswordValidate;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('update_employees');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $employee = request()->route('employee');

        return [
            'name'     => ['required', 'string', 'max:255',new NotNumbersOnly()],
            'phone'    => ['required', 'regex:/^05\d{8}$/','unique:employees,phone,' . $employee->id],
            'password' => ['nullable','exclude_if:password,null','string','min:6','max:255','confirmed',new PasswordValidate()],
            'password_confirmation' => ['nullable','exclude_if:password_confirmation,null','same:password'],
            'email'    => ['required','string', "email:rfc,dns",'unique:employees,email,' . $employee->id],
            'type'      => [  'string' ], // Add type validation
            'roles'    => ['required','array','min:1'],
        ];
    }
}
