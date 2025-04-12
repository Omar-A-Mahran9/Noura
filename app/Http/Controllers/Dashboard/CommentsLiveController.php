<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ArticalComment;
use App\Models\LiveComment;
use Illuminate\Http\Request;

class CommentsLiveController extends Controller
{


    public function index(Request $request)
    {
        // Debugging: Check if article_id is received
        if ($request->ajax()) {
            $this->authorize('view_live');

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



    public function destroy($id)
    {
         $this->authorize('delete_lives'); // Ensure user has permission

        $comment = LiveComment::find($id);

        if (!$comment) {
            return response()->json(['error' => 'comment not found'], 404);
        }

        $comment->delete(); // Delete the article

        return response()->json(['success' => 'comment deleted successfully']);
    }

}
