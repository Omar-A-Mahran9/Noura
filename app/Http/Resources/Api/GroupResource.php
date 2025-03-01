<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'image' => getImagePathFromDirectory($this->image, 'Groups'),
            'title' => $this->name, // Assuming title is a field
            'description' => $this->description, // Assuming description is a field
            'members_count' => $this->vendors()->count(), // Get count of members

        ];    }
}
