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
                'step_3' => QuizQuestionResource::collection($this->questions->skip(8)->take(6)), // Remaining questions
                'step_4' => QuizQuestionResource::collection($this->questions->skip(14)->take(1)), // Remaining questions
                'step_5' => QuizQuestionResource::collection($this->questions->skip(15)->take(1)), // Remaining questions
                'step_6' => QuizQuestionResource::collection($this->questions->skip(16)->take(4)), // Remaining questions
                'step_7' => QuizQuestionResource::collection($this->questions->skip(20)->take(1)), // Remaining questions
                'step_8' => QuizQuestionResource::collection($this->questions->skip(21)->take(4)), // Remaining questions

            ],        ];    }
}
