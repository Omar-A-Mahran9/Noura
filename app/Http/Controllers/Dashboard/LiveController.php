<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreLivesRequest;
use App\Models\Employee;
use App\Models\Live;
use Illuminate\Http\Request;

class LiveController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_live');

        if ($request->ajax())
        {
            $data = getModelData(model: new Live());

             return response()->json($data);
        }

        return view('dashboard.live.index');
    }

    public function create()
    {
        $this->authorize('create_live');
        $employees = Employee::where('type','specialist')->get(); // Assuming you want to fetch all employees

        return view('dashboard.live.create',compact('employees'));
    }


    public function store(StoreLivesRequest $request)
    {
        // Authorize user
        $this->authorize('create_live');

        // Get validated data
        $data = $request->validated();

        // Handle image upload
        if ($request->file('main_image')) {
            $data['main_image'] = uploadImage($request->file('main_image'), "lives");
        }

        // Set time values
        $data['from'] = $request->input('from'); // format: HH:MM
        $data['to'] = $request->input('to');
        $data['publish'] = $request->has('publish') ? 1 : 0;

        // Calculate duration in minutes if both times are set
        if ($data['from'] && $data['to']) {
            $from = \Carbon\Carbon::createFromFormat('H:i', $data['from']);
            $to = \Carbon\Carbon::createFromFormat('H:i', $data['to']);
            $data['duration_minutes'] = $from->diffInMinutes($to);
        }

        // Create Live
        $live = Live::create($data);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Live  $live
     * @return \Illuminate\Http\Response
     */
    public function show(Live $live)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Live  $live
     * @return \Illuminate\Http\Response
     */
    public function edit(Live $live)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Live  $live
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Live $live)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Live  $live
     * @return \Illuminate\Http\Response
     */
    public function destroy(Live $live)
    {
        //
    }
}
