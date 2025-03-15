<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->nem,
            'description' => $this->description,
            'questions' => QuizQuestionResource::collection($this->questions),
        ];    }
}
