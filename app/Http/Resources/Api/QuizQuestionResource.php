<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizQuestionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'is_main' => $this->is_main,
            'name' => $this->name,
             'answers' => QuizAnswerResource::collection($this->answers),
        ];    }
}
