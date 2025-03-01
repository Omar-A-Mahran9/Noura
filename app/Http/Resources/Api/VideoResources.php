<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Str;


class VideoResources extends JsonResource
{

    public function toArray($request)
    {
        return [

            'title' =>  $this->name,
            'video_path'=>$this->video_path

            ];
          }
}
