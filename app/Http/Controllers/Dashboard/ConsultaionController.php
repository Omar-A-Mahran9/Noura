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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_consultation_time');

        // Get types that are NOT used in any consultation
        $types = ConsultaionType::whereDoesntHave('consultaions')
            ->select('id', 'name_' . getLocale())
            ->get();

        return view('dashboard.consultaiondata.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Consultaion  $consultaion
     * @return \Illuminate\Http\Response
     */
    public function show(Consultaion $consultaion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Consultaion  $consultaion
     * @return \Illuminate\Http\Response
     */
    public function edit(Consultaion $consultaion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Consultaion  $consultaion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Consultaion $consultaion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Consultaion  $consultaion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Consultaion $consultaion)
    {
        //
    }
}
