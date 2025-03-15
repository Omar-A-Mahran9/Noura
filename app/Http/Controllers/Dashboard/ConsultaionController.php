<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreConsultationRequest;
use App\Models\Consultaion;
use App\Models\ConsultaionSchedual;
use App\Models\ConsultaionType;
use Illuminate\Http\Request;

class ConsultaionController extends Controller
{


     public function index(Request $request)
    {
         $this->authorize('view_consultation_time');

        if ($request->ajax())
        {
            $data = getModelData(new Consultaion());

             return response()->json($data);
        }

        return view('dashboard.consultaiondata.index');
    }


    public function create()
    {
        $this->authorize('create_consultation_time');

        // Get types that are NOT used in any consultation
        $types = ConsultaionType::whereDoesntHave('consultaions')
            ->select('id', 'name_' . getLocale())
            ->get();

        return view('dashboard.consultaiondata.create', compact('types'));
    }


    public function store(StoreConsultationRequest $request)
    {
         // Get the validated data
         $data = $request->validated();
          // Handle the main image upload
         if ($request->file('main_image')) {
             $data['main_image'] = uploadImage($request->file('main_image'), "Consultation");
         }


      $consultaionData = [
        'title_ar' => $data['title_ar'],
        'title_en' => $data['title_en'],
        'description_ar' => $data['description_ar'],
        'description_en' => $data['description_en'],
         'main_image' =>  $data['main_image'],
         'price' =>  $data['price'],
        'consultaion_type_id'=> $data['consultaion_type_id'],
       ];

      $consultaion=Consultaion::create($consultaionData);

     $consultaiontimes = $request->time_list ?? []; // Retrieve the sections list from the request
      if (is_array($consultaiontimes) && count($consultaiontimes) > 0) {
        foreach ($consultaiontimes as $consultaiontime) {
             // Check if 'available' is set and valid
             $available = isset($consultaiontime['available']) &&
             is_array($consultaiontime['available']) &&
             count($consultaiontime['available']) > 0 &&
             $consultaiontime['available'][0] === 'true' ? 1 : 0;

            // Build the section data
            $sectionData = [
                'consultaion_id' => $consultaion->id,
                'date' => $consultaiontime['date'],
                'time' => $consultaiontime['time'],
                'available' => $available,
            ];

            // Create the section record
            $section = ConsultaionSchedual::create($sectionData);
        }
      }

    }




    public function edit($id)
    {
        $types = ConsultaionType::select('id', 'name_' . getLocale())->get();
        $consultaion = Consultaion::with('consultaionScheduals')->findOrFail($id);
        $this->authorize('update_consultation_time');

        return view('dashboard.consultaiondata.edit', compact('consultaion', 'types'));
    }


    public function update(Request $request, Consultaion $consultaion)
    {
        $data = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'price' => 'required|numeric',
            'consultaion_type_id' => 'required|exists:consultaion_types,id',
            'time_list' => 'nullable|array',
            'time_list.*.date' => 'required_with:time_list|date',
            'time_list.*.time' => 'required_with:time_list|date_format:H:i',
            'time_list.*.available' => 'nullable|boolean',
        ]);

        $consultaion->update($data);

        // Handle time slots
        $consultaion->sections()->delete(); // Remove old times before inserting new ones
        if (!empty($request->time_list)) {
            foreach ($request->time_list as $time) {
                $consultaion->sections()->create([
                    'date' => $time['date'],
                    'time' => $time['time'],
                    'available' => isset($time['available']) && $time['available'] ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('consultaion.index')->with('success', 'Consultation updated successfully');
    }



    public function destroy(Request $request,Consultaion $consultaion)
    {
        $this->authorize('delete_articles');

        if($request->ajax())
        {
            $consultaion->delete();
            deleteImage($consultaion->main_image , 'Consultation' );
        }
    }
}
