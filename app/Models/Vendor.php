<?php

namespace App\Models;

use App\Enums\VendorStatus;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory,SoftDeletes;

    protected $guard = 'vendor'; // This tells the model to use the 'vendor' guard
    protected $guarded = [];
    protected $appends = ['status_name'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    protected $hidden = ['password'];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getStatusNameAttribute()
    {
        // Retrieve the status value from the model's attributes (if it exists)
        $statusValue = $this->attributes['status'] ?? null;

        // If the status value exists and is a valid VendorStatus, return its name
        if ($statusValue !== null) {
            $status = VendorStatus::tryFrom($statusValue);
            // If a valid enum case is found, return its name, otherwise return a default message
            if ($status) {
                return __(ucfirst($status->name)); // The name is the enum case (e.g., "blocked")
            }
        }

        // Return a default value if no status is found or it's invalid
        return __('Unknown status');
    }



    public function sendOTP()
    {
        $this->verification_code = rand(1111, 9999);
        // $this->verification_code = 1234;

        $appName                 = settings()->getSettings("website_name_" . getLocale()) ?? "Noraalsufairy";
         // OtpLink($this->phone,$this->verification_code);

        $this->save();
    }

    public function verifyOTP($verification_code)
    {
         if ($this->verification_code == $verification_code)
        {
            $this->verified_at       = now();
            $this->verification_code = NULL;
            $this->save();
            return TRUE;
        } else
        {
            return FALSE;
        }
        return FALSE;
    }

    public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->belongsToMany(Message::class, 'message_receivers', 'receiver_id', 'message_id')
                ->withTimestamps()
                ->withPivot('read_at');
}


public function providers()
{
    return $this->hasMany(SocialAccount::class);
}


}
