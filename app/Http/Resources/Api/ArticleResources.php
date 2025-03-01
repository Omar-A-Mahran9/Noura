<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Str;

use function PHPSTORM_META\map;

class ArticleResources extends JsonResource
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
             'image' =>  getImagePathFromDirectory($this->main_image, 'articles'), 

            'title' =>  $this->title, 
            'short_description' => Str::limit($this->description, 35),
            'fully_description' =>$this->description,
            'created_at' => $this->created_at->format('Y-m-d'), // Manually format the date
            'comments_counts' => $this->comments->count(), // Total count of comments
            'comments' => $this->comments->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'article_id' => $comment->article_id,
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
            ];  
          }
}
