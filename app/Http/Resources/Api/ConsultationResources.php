<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ConsultationResources extends JsonResource
{
    public static function single($consultaion)
    {
        return new static($consultaion);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'consultaion_type_id' => $this->consultaion_type_id,
            'title' => $this->title, // Assuming title is a field
            'description' => $this->description, // Assuming description is a field
            'image' =>  getImagePathFromDirectory($this->main_image, 'Consultations'),
            'quizzes' => QuizResource::collection($this->quizzes),

        ];
    }
}
