<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $guarded            = [];
    protected $appends            = ['name', 'description'];
    protected $casts              = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];
  
 // In Section model
 public function scopeWithCourse($query)
 {
     return $query->whereNotNull('course_id');
 }
       
    public function videos()
    {
        return $this->hasMany(Video::class,'section_id');
    }
    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale()];
    }
    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale()];
    }
}
