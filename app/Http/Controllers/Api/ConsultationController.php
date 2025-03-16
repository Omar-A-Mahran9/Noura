<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ConsultationResources;
use App\Http\Resources\ConsultationResources as ResourcesConsultationResources;
use App\Models\Consultaion;
use App\Models\ConsultaionSchedual;
use App\Models\ConsultaionType;
use Carbon\Carbon;
use Illuminate\Http\Request  ;

class ConsultationController extends Controller
{

public function getTime(Request $request)
{
    // Validate the incoming request for 'date' and 'consultaion_type_id'
    $request->validate([
        'date' => 'required|date', // Ensure 'date' is required and a valid date
        'consultaion_type_id' => 'required|integer', // Ensure 'consultaion_type_id' is required and an integer
    ]);

    // Retrieve the 'date' and 'consultaion_type_id' from the request
    $date = $request->input('date');
    $consultaionTypeId = $request->input('consultaion_type_id');

    // Find the first consultaion of the specified consultaion_type_id
    $consultaion = Consultaion::where('consultaion_type_id', $consultaionTypeId)->first();

    // If no consultaion is found, return an empty response
    if (!$consultaion) {
        return $this->success(data:[]) ;
    }
    $availableTimes = $consultaion->consultaionScheduals()
    ->where('date', $date) // Filter by date
    ->where('available', 1) // Filter by date

    ->pluck('time') // Extract only the 'time' field
    ->map(function ($time) {
        // Format each time to AM/PM format using Carbon
        return Carbon::parse($time)->format('h:i A'); // Converts to 'hh:mm AM/PM' format
    });

        // Return the available times as a JSON response
          return $this->success(data: $availableTimes);

 }

    public function consultation_page(Request $request)
    {
        dd($consultaionTypeId);

        // Validate the incoming request for 'date' and 'consultaion_type_id'
        $request->validate([
            'consultaion_type_id' => 'required|integer', // Ensure 'consultaion_type_id' is required and an integer
        ]);


        $consultaionTypeId = $request->input('consultaion_type_id');

        // Find the first consultaion of the specified consultaion_type_id
        $consultaion = Consultaion::where('consultaion_type_id', $consultaionTypeId)->first();

        // If no consultaion is found, return an empty response
        if (!$consultaion) {
            return $this->success(data:[]) ;
        }
        // Use the ConsultationResources to transform the consultaion data
        $consultaiondata =  ConsultationResources::single($consultaion)->resolve();

        // Return the transformed consultaion data as a JSON response
        return $this->success(data: $consultaiondata);

    }

    public function getType()
    {
        $consultaionTypes = ConsultaionType::latest()->take(4)->get();
         return $this->success(data: $consultaionTypes);

    }


}
