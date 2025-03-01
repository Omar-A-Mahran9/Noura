<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreQuizRequest;
use App\Models\Consultaion;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Quizze;
use App\Models\Section;
use Illuminate\Http\Request;

class QuizzeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view_quizzes');

        if ($request->ajax())
        {
            $data = getModelData( new Quiz(),[ 'course' => ['id','name_' .getLocale(),'description_' .getLocale()],'section' => ['id','name_' .getLocale(),'description_' .getLocale()]]);
         return response()->json($data);
        }

        return view('dashboard.quizes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create_quizzes');
         $Consultaion        = Consultaion::select('id','title_' . getLocale())->get();
         return view('dashboard.quizes.create',compact('Consultaion'));
    }


    public function store(StoreQuizRequest $request)
    {
        $this->authorize('create_quizzes');
        $data = $request->validated();

        $Quiz = Quiz::create($data);
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quizze  $quizze
     * @return \Illuminate\Http\Response
     */
    public function show(Quizze $quizze)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quizze  $quizze
     * @return \Illuminate\Http\Response
     */
    public function edit(Quizze $quizze)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Quizze  $quizze
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quizze $quizze)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quizze  $quizze
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quizze $quizze)
    {
        //
    }
}
