<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreQuestionRequest;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionsController extends Controller
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
    public function create(Request $request)
    {
        $this->authorize('create_questions');
        $quizzes        = Quiz::select('id','name_' . getLocale())->get();
        $type = $request->query('type', 'single'); // Default to 'default' if not set

        return view('dashboard.quizes.questions.create',compact('quizzes','type'));
    }
    public function store(StoreQuestionRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {
            // Create question
            $question = QuizQuestion::create([
                'quiz_id' => $data['quiz_id'],
                'type' => $data['type'],
                'is_main' => $data['is_main'] ?? 0, // Default to 0 if not provided
                'name_ar' => $data['name_ar'],
                'name_en' => $data['name_en'],
            ]);

            // Only process answers if 'answer_list' exists and is an array
            $answers = [];
            if (!empty($data['answer_list']) && is_array($data['answer_list'])) {
                $answers = collect($data['answer_list'])->map(function ($answer) use ($question) {
                    return QuizAnswer::create([
                        'question_id' => $question->id,
                        'name_ar' => $answer['name_ar'],
                        'name_en' => $answer['name_en'],
                    ]);
                });
            }

            return response()->json([
                'message' => 'Question added successfully!',
                'question' => $question,
                'answers' => $answers,
            ]);
        });
    }
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
