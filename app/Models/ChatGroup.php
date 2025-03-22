<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends            = ['name', 'description'];

    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class, 'chat_group_vendor');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_group_id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_'. getLocale()];
    }
    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale()];
    }
}
