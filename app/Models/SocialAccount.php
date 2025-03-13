<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable = ['vendor_id', 'provider', 'provider_id', 'avatar'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
