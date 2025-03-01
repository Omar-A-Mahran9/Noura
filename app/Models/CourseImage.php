<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseImage extends Model
{
    use HasFactory;
        // Define the table if it's different from the default (optional)
        protected $table = 'course_images';

        // Define the fillable fields
        protected $fillable = [
            'course_id',
            'image',
        ];

    public function course()
        {
            return $this->belongsTo(Course::class);
        }
}
