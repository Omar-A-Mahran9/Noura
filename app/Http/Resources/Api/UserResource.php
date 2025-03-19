<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'image' =>  getImagePathFromDirectory($this->image, 'ProfileImages'),
                'name' => $this->name,
                'phone' => $this->phone,
                'email' => $this->email,
                'another_phone' => $this->another_phone,
                'address' => $this->address,
                'status' => $this->status,
                'status_name' => $this->status_name,
                'last_seen' => $this->last_seen,
                'identity_no' => $this->identity_no,
                'google_maps_url' => $this->google_maps_url,
                'rejection_reason' => $this->rejection_reason,
                'created_by' => $this->created_by,
                'terms_and_conditions' => $this->Terms_and_conditions,
                'created_by_social' => $this->created_by_social,
                'verification_code' => $this->verification_code,
                'verified_at' => $this->verified_at,
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            ];
    }
}
