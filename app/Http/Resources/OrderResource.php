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
                'id' => $this->book->id,

                'title' => $this->book->title,
                'description' => $this->book->description,
                'price' => $this->book->price,
            ] : null,

            'course' => $this->course ? [
                'id' => $this->course->id,

                'name' => $this->course->name,
                'description' => $this->course->description,
                'price' => $this->course->price,
            ] : null,

           'consultation' => $this->consultation ? [
            'id' => $this->consultaionType->id,

            'title' => $this->consultaionType->name,
            'description' => $this->consultaionType->name,
            'price' => $this->consultation->price,
            // 'schedule' => $this->consultation->schedule ? [
            //     'start_date' => $this->consultation->schedule->start_date,
            //     'end_date' => $this->consultation->schedule->end_date,
            // ] : null,
            // 'consultation_type' => $this->consultation->type ? [
            //     'type' => $this->consultation->type->name,
            // ] : null,
        ] : null,
        ];    }
}
