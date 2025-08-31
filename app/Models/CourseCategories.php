<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategories extends Model
{
    use HasFactory;
    protected $table = 'coursecategories';
    protected $guarded = [];
    protected $appends = ['name'];
    protected $casts   = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d'
    ];
    public function getNameAttribute()
    {
        return $this->attributes['name_'. getLocale()];
    }
public function courses()
{
    return $this->belongsToMany(Course::class, 'course_category', 'coursecategories_id','course_id');
}


}
