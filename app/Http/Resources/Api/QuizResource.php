<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class QuizResource extends JsonResource
{

    public function toArray($request)
    {

// Get the consultaion_type_id from the request and convert it to an integer
$consultaionTypeId = (int) $request->input('consultaion_type_id');


            // Apply different logic if consultaion_type_id == 1
            if ($consultaionTypeId == 1) {
                return [
                    'id' => $this->id,
                    'title' => $this->name,
                    'description' => $this->description,
                    'steps' => [
                        'step_1' => QuizQuestionResource::collection($this->questions->take(5)),
                        'step_2' => QuizQuestionResource::collection($this->questions->skip(5)->take(3)),
                        'step_3' => QuizQuestionResource::collection($this->questions->skip(8)->take(6)),
                        'step_4' => QuizQuestionResource::collection($this->questions->skip(14)->take(1)),
                        'step_5' => QuizQuestionResource::collection($this->questions->skip(15)->take(1)),
                        'step_6' => QuizQuestionResource::collection($this->questions->skip(16)->take(4)),
                        'step_7' => QuizQuestionResource::collection($this->questions->skip(20)->take(1)),
                        'step_8' => QuizQuestionResource::collection($this->questions->skip(21)->take(4)),
                    ],
                ];
            }

            elseif ($consultaionTypeId == 2) {
                return [
                    'id' => $this->id,
                    'title' => $this->name,
                    'description' => $this->description,
                    'steps' => [
                        'step_1' => QuizQuestionResource::collection($this->questions->take(7)),
                        'step_2' => QuizQuestionResource::collection($this->questions->skip(7)->take(1)),
                        'step_3' => QuizQuestionResource::collection($this->questions->skip(8)->take(1)),
                        'step_4' => QuizQuestionResource::collection($this->questions->skip(9)->take(3)),
                        'step_5' => QuizQuestionResource::collection($this->questions->skip(15)->take(1)),
                        'step_6' => QuizQuestionResource::collection($this->questions->skip(16)->take(4)),
                        'step_7' => QuizQuestionResource::collection($this->questions->skip(20)->take(1)),
                        'step_8' => QuizQuestionResource::collection($this->questions->skip(21)->take(4)),
                    ],
                ];
            }

            elseif ($consultaionTypeId == 3) {
                return [
                    'id' => $this->id,
                    'title' => $this->name,
                    'description' => $this->description,
                    'steps' => [
                        'step_1' => QuizQuestionResource::collection($this->questions->take(20)),

                    ],
                ];
            }
            else{
                return [
                    'id' => $this->id,
                    'title' => $this->name,
                    'description' => $this->description,
                    'questions' => QuizQuestionResource::collection($this->questions),
                ];
            }


            // Default response


    }
}
