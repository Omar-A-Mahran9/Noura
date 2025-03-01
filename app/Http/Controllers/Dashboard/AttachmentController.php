<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreAttachmentRequest;
use App\Models\Attachment;
use App\Models\Attachmnet;
use App\Models\Course;
use App\Models\Section;
use Arr;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_attachment_materials');
        $courses = Course::getApprovedCourses();  // Get approved courses based on global scope
        $section        = Section::select('id','name_' . getLocale())->get();

        return view('dashboard.Courses.attachment.create',compact('courses','section'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAttachmentRequest $request)
    {
 
        $this->authorize('create_attachment_materials');
        $data = $request->validated();
        if ($request->file('file_path'))
        {
            deleteFile( $data['file_path'] , "Attachments");
            $data['file_path'] = uploadFile( $request->file('file_path') , "Attachments");
        }     
        $dataWithoutCourseId = Arr::except($data, ['course_id']);
        Attachment::create($dataWithoutCourseId);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
