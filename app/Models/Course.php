<?php

namespace App\Models;

use App\Enums\CoursesStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded            = [];
    protected $appends            = ['name', 'description'];
    protected $casts              = ['created_at' => 'date:Y-m-d', 'updated_at' => 'date:Y-m-d'];


    protected static function booted()
    {
        if(request()->segment(1) != 'dashboard')
        {
            static::addGlobalScope('status', function(Builder $builder){
                $builder->where('status', CoursesStatus::approved->value);
            });
        }
    }

      // Get courses by status 2 (approved)
      public static function getApprovedCourses()
      {
          $courses = self::where('status', 2)
              ->select('id', 'name_' . getLocale())  // Dynamic locale column
              ->get();

          return $courses;
      }





    public function getNameAttribute()
    {
        return $this->attributes['name_' . getLocale()];
    }
    public function getDescriptionAttribute()
    {
        return $this->attributes['description_' . getLocale()];
    }

    public function sections() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Section::class)->withCourse();
    }
      // Example of how to fetch sections for a course and handle them
      public function getSectionsForCourse()
      {
          $sections = $this->sections()->get(); // Fetch all sections associated with the course

          // If you need additional logic for sections or transforming data, you can do it here
          return $sections;
      }



      public function courseImages()
      {
          return $this->hasMany(CourseImage::class);
      }

    public function outcomes() : \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Outcome::class)->withCourse();
    }
      // Example of how to fetch sections for a course and handle them
      public function getOutcomesForCourse()
      {
          $sections = $this->outcomes()->get(); // Fetch all sections associated with the course

          // If you need additional logic for sections or transforming data, you can do it here
          return $sections;
      }
      public function videos()
      {
          return $this->hasManyThrough(Video::class, Section::class, 'course_id', 'section_id');
      }

public function categories()
{
    return $this->belongsToMany(CourseCategories::class, 'course_category', 'course_id', 'coursecategories_id');
}

public function relatedCourses()
{
    return $this->belongsToMany(Course::class, 'course_category', 'course_id', 'coursecategories_id')
        ->where('courses.id', '!=', $this->id);
}



}
