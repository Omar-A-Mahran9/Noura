<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
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

    public function bookImages()
    {
        return $this->hasMany(BookImage::class);
    }

    public function comments()
    {
        return $this->hasMany(BookComment::class, 'book_id');
    }
    public function author()
    {
        return $this->belongsTo(Employee::class, 'assign_to');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'book_course', 'course_id', 'book_id');
    }
}

