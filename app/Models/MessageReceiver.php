<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageReceiver extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Vendor::class, 'receiver_id');
    }
}
