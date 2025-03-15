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
            'steps' => [
                'step_1' => QuizQuestionResource::collection($this->questions->take(5)),
                'step_2' => QuizQuestionResource::collection($this->questions->skip(5)->take(3)),
                'step_3' => QuizQuestionResource::collection($this->questions->skip(8)), // Remaining questions
            ],        ];    }
}
