<?php
namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class VendorResources extends JsonResource
{
    public static function single($consultaion)
    {
        return new static($consultaion);
    }

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
           
        ];
    }
}
