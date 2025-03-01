<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function chatGroup()
    {
        return $this->belongsTo(ChatGroup::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'sender_id');
    }

    public function receivers()
    {
        return $this->belongsToMany(Vendor::class, 'message_receivers', 'message_id', 'receiver_id')
                    ->withTimestamps()
                    ->withPivot('read_at');
    }
}
