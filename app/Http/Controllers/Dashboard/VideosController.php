<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreVideoRequest;
use App\Models\Course;
use App\Models\Section;
use App\Models\Video;
use Arr;
use Illuminate\Http\Request;

class VideosController extends Controller
{



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_videos_materials');
        $courses = Course::getApprovedCourses();  // Get approved courses based on global scope
        $section        = Section::select('id','name_' . getLocale())->get();

        return view('dashboard.Courses.videos.create',compact('courses','section'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVideoRequest $request)
    {
        $this->authorize('create_videos_materials');
        $data = $request->validated();
        $dataWithoutCourseId = Arr::except($data, ['course_id']);
        Video::create($dataWithoutCourseId);
    }

    public function show(Request $request)
    {
        $this->authorize('view_videos_materials');

        if ($request->ajax())
        {
            $data = getModelData( model: new Video() );

            return response()->json($data);
        }

        return view('dashboard.courses.videos.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


  public function destroy(Request $request , Video $video)
        {
            $this->authorize('delete_videos_materials');

            if ($request->ajax())
            {
                $video->delete();
             }

        }
}
