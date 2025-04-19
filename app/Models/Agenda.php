<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['title','description'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];

    public function getTitleAttribute()
    {
        return $this->attributes['title_' . getLocale()];
    }

    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale()];
    }
    public function lives()
    {
        return $this->belongsTo(Live::class); // Ensure you have a Vendor model
    }
}
