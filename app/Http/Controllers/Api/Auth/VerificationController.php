<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enums\VendorStatus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{

    public function resendOtp(Request $request)
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
         $code= $user->sendOTP();
         }
        return $this->success(data: ['verification_code' => $user->verification_code]);
    }

    public function verifyOtp(Request $request)
    {
         
        $result=null;
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
        $result = $user->verifyOTP($request->otp);

        if($user->status==2 || $user->status==1 && $result==true){

            $user->status = VendorStatus::approved->value;

        }
        $user->save();
       }
        return $result ? $this->success(data:$user->status_name) : $this->validationFailure(errors: __('wrong data please check your number or email and send correct otp'));
    }
}
