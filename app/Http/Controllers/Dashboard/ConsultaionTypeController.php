<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreConsultationTypeRequest;
use App\Http\Requests\Dashboard\UpdateConsultationTypeRequest;
use App\Models\ConsultaionType;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class ConsultaionTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $this->authorize('view_consultation_type');
        if ( $request->ajax() ) {
 
            $brands = getModelData( model: new ConsultaionType() , searchingColumns: ['name_ar', 'name_en'] );

            return response()->json($brands);
        }
        return view('dashboard.consultationtype.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_consultation_type');
 
        return view('dashboard.consultationtype.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreConsultationTypeRequest $request)
    {
        
        $this->authorize('create_consultation_type');
        $data = $request->validated();
        ConsultaionType::create($data);
    }

 

    public function show(ConsultaionType $ConsultaionType)
    {
         $this->authorize('show_consultation_type');
        return view('dashboard.consultationtype.show',compact('ConsultaionType' ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
 

    public function edit(ConsultaionType $ConsultaionType)
    {
        $this->authorize('show_consultation_type');

        return view('dashboard.consultationtype.edit',compact('ConsultaionType' ));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateConsultationTypeRequest $request, ConsultaionType $ConsultaionType)
    {
        $this->authorize('update_consultation_type');
        $data = $request->validated();
        $ConsultaionType->update($data);
    }

    public function destroy(Request $request, ConsultaionType $consultaionType)
    {
        $this->authorize('delete_consultation_type');  // Make sure this policy exists
    
        if ($request->ajax()) {
            // Attempt to delete the ConsultaionType
            $consultaionType->delete();
            return response()->json(['success' => 'Consultaion Type deleted successfully']);
        }
    
        // Fallback if not an AJAX request
        return redirect()->route('consultationtype.index')->with('success', 'Consultaion Type deleted successfully');
    }
}    