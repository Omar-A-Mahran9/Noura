<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticalComment;
use App\Models\LiveComment;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Request $request)
    {
        // Debugging: Check if article_id is received
        if ($request->ajax()) {
            $this->authorize('view_articles');

            // Ensure article_id is provided
            if (!$request->has('article_id')) {
                return response()->json(['error' => 'Article ID is required'], 400);
            }

            // Fetch comments filtered by article_id
            $data = getModelData(
                model: new ArticalComment(),
                andsFilters: [['article_id', '=', $request->article_id]], // Apply filter
                relations: ['vendor' => ['id', 'name']]
            );

            return response()->json($data);
        }

        return view('dashboard.articles.show');
    }


    public function indexcommentlives(Request $request)
    {
        // Debugging: Check if article_id is received
        if ($request->ajax()) {
            $this->authorize('view_lives');

            // Ensure article_id is provided
            if (!$request->has('live_id')) {
                return response()->json(['error' => 'live ID is required'], 400);
            }

            // Fetch comments filtered by article_id
            $data = getModelData(
                model: new LiveComment(),
                andsFilters: [['live_id', '=', $request->live_id]], // Apply filter
                relations: ['vendor' => ['id', 'name']]
            );

            return response()->json($data);
        }

        return view('dashboard.lives.show');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function destroy($id)
    {
         $this->authorize('delete_articles'); // Ensure user has permission

        $comment = ArticalComment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'comment not found'], 404);
        }

        $comment->delete(); // Delete the article

        return response()->json(['success' => 'comment deleted successfully']);
    }

}
