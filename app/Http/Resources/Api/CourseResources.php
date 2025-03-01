<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Str;


class CourseResources extends JsonResource
{

    public function toArray($request)
    {
        return [
             'id' => $this->id,
            'image' => getImagePathFromDirectory($this->images, 'Courses'),
            'images' => $this->courseImages->map(function ($image) {
                return getImagePathFromDirectory($image->image, 'Courses/images');
            }),
            'title' =>  $this->name,
            'price'=>$this->have_discount?$this->discount_price:$this->price,
            'price_before_discount'=>$this->have_discount?$this->price:null,
            'total_count_lecture' => $this->sections->load('videos')->sum(function ($section) {
                return $section->videos->count();
            }),
            'sections_videos' => $this->sections->map(function ($section) {
                return [
                    'section_name' => $section->name, // Assuming 'name' is the localized section name
                    'videos' => $section->videos->map(function ($video) {
                        return [
                            'id' => $video->id,
                            'title' => $video->name, // Assuming 'title' exists in Video model
                            'time' => "30 min",   // Assuming 'time' exists in Video model
                        ];
                    }),
                ];
            }),            'short_description' => Str::limit($this->description, 135),
            'fully_description' =>$this->description,
            'categories' =>$this->categories,

            'outcome' =>$this->outcomes->map(function($q){
                return $q->description;
            }),
            'related_courses' => $this->relatedCourses->map(function ($course) {
                        return [
                            'id' => $course->id,
                            'title' => $course->name,
                            'price' => $course->have_discount ? $course->discount_price : $course->price,
                            'image' => getImagePathFromDirectory($course->images, 'Courses'),
                        ];
                    }),
            'created_at' => $this->created_at->format('Y-m-d'), // Manually format the date

            ];
          }
}
