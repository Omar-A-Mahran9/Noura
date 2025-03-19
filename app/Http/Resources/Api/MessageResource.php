<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'chat_group_id' => $this->chat_group_id,
            'sender_id' => $this->sender_id,
            'message' => $this->message,
            // 'file' => $this->file,
            'file' => $this->file ?getImagePathFromDirectory( $this->file, 'Messages'):null,

            'time' => $this->created_at ? $this->created_at->format('h:i A') : null,

            'sender' => [
                'id' => $this->vendor->id,

                 'image' => getImagePathFromDirectory( $this->vendor->image, 'ProfileImages'),
                'name' => $this->vendor->name
            ],
            'receivers' => $this->receivers->map(function ($receiver) {
                return [
                    'id' => $receiver->id,
                    'name' => $receiver->name, // Assuming there is an image field
                    'image' => getImagePathFromDirectory( $receiver->image, 'ProfileImages'),
                    'read_at' => $receiver->pivot->read_at ? $receiver->pivot->read_at : null

                ];
            }),
        ];    }
}
