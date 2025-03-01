<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;
    protected $guarded            = [];
    protected $appends            = [ 'description'];
    protected $casts              = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];
    
     // In Section model
 public function scopeWithCourse($query)
 {
     return $query->whereNotNull('course_id');
 }
    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale()];
    }
}
