<?php

namespace App\Http\Controllers\Api;

use App\Enums\CarStatus;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Site\UpdateUserController;
use App\Models\CarImage;
use App\Models\CarModel;
use App\Models\Favorite;
use App\Models\OrderNotification;
use App\Models\SettingOrderStatus;
use App\Models\Vendor;
use App\Rules\NotNumbersOnly;
use App\Rules\PasswordValidate;
use DB;
use GrahamCampbell\ResultType\Success;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Config;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{


    public function profile()
    {
        return $this->success(data: auth()->user());
    }


    public function updateProfile(Request $request)
    {
        $vendor = Auth::user();

        // Validate only provided fields (before conversion)
        $validatedData = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                new NotNumbersOnly(),
                Rule::unique('vendors', 'name')->ignore($vendor->id),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('vendors')->ignore($vendor->id),
            ],
            'phone' => [
                'sometimes',
                'string',
                'regex:/^((\+|00)966|0)?5[0-9]{8}$/',
                Rule::unique('vendors')->ignore($vendor->id),
            ]
        ]);

        // Convert Arabic numbers AFTER validation
        if ($request->filled('phone')) {
            $validatedData['phone'] = convertArabicNumbers($validatedData['phone']);
        }

        // Update only the provided fields
        $vendor->update($validatedData);

        return $this->success(data: $vendor);
    }




    public function changPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed',new PasswordValidate()],
            'password_confirmation' => ['required','same:password'],
        ]);

        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $errors = [
                'old_password' => [__('The old password is incorrect')],
                // 'another_key' => ['Another error message'],
            ];

            return $this->validationFailure(errors:  $errors);
        } else {
            $usser = Vendor::where('phone', $user->phone)->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return $this->success(data:$usser, message: __('Password updated successfully'));
    }
 
}
