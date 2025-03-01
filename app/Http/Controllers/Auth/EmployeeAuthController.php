<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:employee')->except('logout');
    }


    public function showLoginForm()
    {
        return view('auth.employee_login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email'   => 'required|email|exists:employees',
            'password' => 'required|min:6'
        ]);

        $employee = Employee::where('email',$request->email)->first();

        if ($employee)
        {
            if(Hash::check($request->password, $employee->password))
            {
                Auth::guard('employee')->login($employee,true);
                return redirect()->intended('/dashboard');
            }
            else
            {
                throw ValidationException::withMessages([
                    "password" => __("The password is incorrect"),
                ]);
            }

        }else
        {
            throw ValidationException::withMessages([
                "password" => __("The password is incorrect"),
                "email" => __("This email doesn't exist"),
            ]);
        }

    }


    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect()->route('employee.login');
    }
}
