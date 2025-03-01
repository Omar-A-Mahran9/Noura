<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class BookResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => getImagePathFromDirectory($this->main_image, 'books'), 
            'title' => $this->title, 
            'rate' => $this->rate, 
            'short_description' => Str::limit($this->description, 35),
            'fully_description' => $this->description,
            'created_at' => $this->created_at->format('Y-m-d'),
            'images' => $this->bookImages->map(function ($image) {
                return getImagePathFromDirectory($image->image, 'books/images');
            }),            // Map the related comments if available
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'description' => $this->author->description,

                'image' => getImagePathFromDirectory($this->author->image, 'authors'),
            ],
            'comments_count' => $this->comments->count(), // Count of comments

            'comments' => $this->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'book_id' => $comment->book_id,
                    'book_id' => $comment->rate,
                    'vendor_id' => $comment->vendor_id,
                    'description' => $comment->description,
                    'vendor' => [
                        'id' => $comment->vendor->id, // Ensure the vendor has 'id' property
                        'name' => $comment->vendor->name, // Assuming you have a 'name' field in the vendor
                        'image' =>  getImagePathFromDirectory($comment->vendor->image, 'Vendors'), 

                    ],
                    'created_at' => $comment->created_at->format('Y-m-d'),
                ];
            }),
            'rate_count' => $this->comments->count(), // Count of comments

            'rate_percentage' => collect([1, 2, 3, 4, 5])->map(function ($rate) {
                $totalComments = $this->comments->count();
                $rateCount = $this->comments->where('rate', $rate)->count();
                return [
                    'rate' => $rate,
                    'percentage' => $totalComments > 0 ? round(($rateCount / $totalComments) * 100, 2) : 0
                ];
            }),

            'related_courses'=>'',

            ];      
    }
}
