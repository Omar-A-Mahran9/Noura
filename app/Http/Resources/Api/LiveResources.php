<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LiveResources extends JsonResource
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
            'image' => getImagePathFromDirectory($this->main_image, 'lives'),
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'price_after_discount' => $this->price,
            'is_free' => true,
            'have_discount' => true,
            'discount_percentge' => true,
            'status'=>"new",
            'day_date' => $this->day_date ? $this->day_date : null,
            'from' => $this->from ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)->format('h:i A') : null,
            'to'   => $this->to ? \Carbon\Carbon::createFromFormat('H:i:s', $this->to)->format('h:i A') : null,
            'previwe_video' => $this->video_url,
            'live_start_durin' => $this->from && $this->to
                ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)
                    ->diff(\Carbon\Carbon::createFromFormat('H:i:s', $this->to))
                    ->format('%d days %h hours %i minutes %s seconds')
                : null,

            'duration_minutes' => $this->duration_minutes,
            'publish' => $this->publish,

            'created_at' => $this->created_at->format('Y-m-d'),

        ];
    }
}
