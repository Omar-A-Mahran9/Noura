<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Site\SendOtpRquest;
use App\Http\Requests\Site\ResetPasswordRquest;

class ForgetPasswordController extends Controller
{
    public function sendOtp(SendOtpRquest $request)
    {

        $phone=$request->phone;
        $email=$request->email;
        $user=null;

        if ($phone){
            $phone=convertArabicNumbers($phone);
            $user = Vendor::where('phone',$phone)->first();
            if (!$user){
            return $this->validationFailure(errors: __('this account not found please review your phone'));
            }
        }
        if ($email){
            $user = Vendor::where('email',$email)->first();
            if (!$user){
              return $this->validationFailure(errors: __('this account not found please review your email'));

            }
      }

         if($user){
            $user->sendOTP();
            // OtpLink(  $vendor->phone, $vendor->verification_code);

            return $this->success(data: ['verification_code' => $user->verification_code]);
        }
    
    }
    public function verifyOtp(Request $request)
    {
        $phone=convertArabicNumbers($request->phone);

        $vendor = Vendor::where('phone', $phone)->first();
        $result = $vendor->verifyOTP($request->otp);
        return $result ? $this->success() : $this->validationFailure(errors: __('wrong code'));
    }
    public function resendOtp(SendOtpRquest $request)
    {
         $phone=convertArabicNumbers($request->phone);
         $vendor = Vendor::where('phone', $phone)->first();
        $vendor->sendOTP();
        // OtpLink(  $vendor->phone, $vendor->verification_code);

        return $this->success(data: ['verification_code' =>  '-']);
    }
    public function resetPassword(ResetPasswordRquest $request)
    {
        $user=null;
        $phone=$request->phone;
        $email=$request->email;
        $user=null;

        if ($phone){
            $phone=convertArabicNumbers($phone);
            $user = Vendor::where('phone',$phone)->first();
            if (!$user){
            return $this->validationFailure(errors: __('this account not found please review your phone'));
            }
        }
        if ($email){
            $user = Vendor::where('email',$email)->first();
            if (!$user){
              return $this->validationFailure(errors: __('this account not found please review your email'));
            }
        }
        if($user){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
            return $this->success(); 
        } else{
            return $this->failure(message: __('wrong update please try again and confirm your number or phone'));
        }
    }
}
