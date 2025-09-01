<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreLivesRequest;
use App\Http\Requests\Dashboard\UpdateLivesRequest;
use App\Models\Employee;
use App\Models\Live;
use Illuminate\Http\Request;
use MacsiDigital\Zoom\Facades\Zoom;

class LiveController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view_live');

        if ($request->ajax())
        {
            $data = getModelData(model: new Live(),relations:['specilist' => ['id', 'name','description_ar','description_en']
]);

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
        // Set is_free flag based on price
        $data['is_free'] = $data['price'] == 0 ? 1 : 0;
        if($request->has('have_discount')){
        $data['have_discount'] = $data['have_discount'] == 'on' ? 1 : 0;

        }

        // Calculate duration in minutes if both times are set
        if ($data['from'] && $data['to']) {
            $from = \Carbon\Carbon::createFromFormat('H:i', $data['from']);
            $to = \Carbon\Carbon::createFromFormat('H:i', $data['to']);
            $data['duration_minutes'] = $from->diffInMinutes($to);
        }

        $meetingData = [
            'topic'      => "Live: " .  $data['title_en'],
            'start_time' => $data['day_date'] . 'T' . $data['from'],
            'duration'   => $data['duration_minutes'],
            'agenda'     => "Scheduled Live session",
        ];
        $meeting = $this->createLiveSession($meetingData);

        // Save meeting details into $data
        $data['zoom_meeting_id'] = $meeting->id;
        $data['zoom_join_url']   = $meeting->join_url;
        $data['zoom_start_url']  = $meeting->start_url;


        // Create Live
        $live = Live::create($data);

    }


    public function edit(  $id)
    {
        $live=Live::find($id);
        $this->authorize('update_live');
        $employees = Employee::where('type','specialist')->get(); // Assuming you want to fetch all employees

        return view('dashboard.live.edit',compact('live','employees'));
    }

    public function update(UpdateLivesRequest $request, $id)
    {
        $live = Live::findOrFail($id);

        // Authorize user
        $this->authorize('update_live');

        // Get validated data from the request
        $data = $request->validated();

        // Handle main image update
        if ($request->file('main_image')) {
            // Delete the old image
            deleteImage($live->main_image, 'lives');

            // Upload the new image
            $data['main_image'] = uploadImage($request->file('main_image'), "lives");
        }

        // Handle time values
        $data['from'] = $request->input('from'); // format: HH:MM
        $data['to'] = $request->input('to');
        $data['publish'] = $request->has('publish') ? 1 : 0;

        // Calculate the duration if both times are set
        if ($data['from'] && $data['to']) {
            $from = \Carbon\Carbon::createFromFormat('H:i', $data['from']);
            $to = \Carbon\Carbon::createFromFormat('H:i', $data['to']);
            $data['duration_minutes'] = $from->diffInMinutes($to);
        }
         // Create or update Zoom live session
        // $startDateTime = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $live->day_date . ' ' . $data['from']);

        $meetingData = [
            'topic'      => "Live: " . $data['title_en'],
            'start_time' => $data['day_date'] . 'T' . $data['from'],
            'duration'   => $data['duration_minutes'],
            'agenda'     => "Scheduled Live session",
        ];

        // If already has a Zoom meeting, delete and recreate it (or you can update if you prefer)
        if ($live->zoom_meeting_id) {
            $this->deleteZoomMeeting($live->zoom_meeting_id);
        }

        // Create a new Zoom meeting
        $meeting = $this->createLiveSession($meetingData);

        // Update Zoom meeting details into $data
        $data['zoom_meeting_id'] = $meeting->id;
        $data['zoom_join_url']   = $meeting->join_url;
        $data['zoom_start_url']  = $meeting->start_url;

        // Update the Live event in the database
        $live->update($data);
    }


    public function show(  $id)
    {
        $live=Live::find($id);
        $this->authorize('update_live');
        $employees = Employee::where('type','specialist')->get(); // Assuming you want to fetch all employees

        return view('dashboard.live.show',compact('live','employees'));
    }


    public function createLiveSession($data)
    {
        $user = Zoom::user()->first();

        $meeting = $user->meetings()->create([
            'topic'      => $data['topic'],
            'type'       => 2, // Scheduled Meeting
            'start_time' => $data['start_time'],
            'duration'   => $data['duration'], // in minutes
            'timezone'   => 'UTC',
            'agenda'     => $data['agenda'],
            'settings'   => [
                'host_video'          => true,
                'participant_video'   => true,
                'mute_upon_entry'     => true,
                'waiting_room'        => true,
            ]
        ]);

        return $meeting;
    }

    public function deleteZoomMeeting($meetingId)
{
    $meeting = Zoom::meeting()->find($meetingId);

    if ($meeting) {
        $meeting->delete();
    }
}



}
