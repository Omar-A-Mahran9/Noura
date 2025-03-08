<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'vendor_id' => $this->vendor_id,
            'total_price' => $this->total_price,
            'payment_status' => $this->payment_status,
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at->toDateTimeString(),

            'book' => $this->book ? [
                'title' => $this->book->title,
                'description' => $this->book->description,
                'price' => $this->book->price,
            ] : null,

            'course' => $this->course ? [
                'name' => $this->course->name,
                'description' => $this->course->description,
                'price' => $this->course->price,
            ] : null,

            'consultation' => $this->consultation ? [
                'title' => $this->consultation->title,
                'description' => $this->consultation->description,
                'price' => $this->consultation->price,
            ] : null,
        ];    }
}
