<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\LiveResources;
use App\Http\Resources\Api\LivesingleResources;
use App\Models\Live;
use App\Models\LiveComment;
use App\Models\Order;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class liveController extends Controller
{

        public function index(Request $request)
        {
            $query = Live::where('publish', 1);

            $status = $request->query('status');
            $now = Carbon::now();
            $today = Carbon::today();

            if ($status === 'current') {
                $query->where('day_date', $today);

            } elseif ($status === 'future') {
                $query->where(function ($q) use ($today ) {
                    $q->where('day_date', '>', $today)
                      ->orWhere(function ($q2) use ($today ) {
                          $q2->where('day_date', $today);
                      });
                });

            } elseif ($status === 'past') {
                $query->where(function ($q) use ($today ) {
                    $q->where('day_date', '<', $today)
                      ->orWhere(function ($q2) use ($today ) {
                          $q2->where('day_date', $today);

                      });
                });
            }
            // Paginate the results - 6 per page
            $lives = $query->latest()->paginate(6);

            return $this->successWithPagination('lives', LiveResources::collection($lives));

        }

        public function single($id)
        {
            // Retrieve the live event by ID
            $live = Live::find($id);

            // Check if the live event exists
            if (!$live) {
                return response()->json([
                    'success' => false,
                    'message' => 'Live event not found',
                ] );
            }

            return $this->success('live', new LivesingleResources($live));
        }

        public function createCommentes(Request $request)
        {
            $data = $request->validate([
                'live_id' => 'required|exists:lives,id',
                'comment' => 'required|string|max:500',
                'rate' => 'required|numeric|min:1|max:5', // Correct rule for numeric validation
            ]);

           if(Auth::guard('vendor')->user()){
               if(Auth::guard('vendor')->user()->status != 2){
               if(Auth::guard('vendor')->user()->status==1){
                     return $this->validationFailure(errors:['message'=>__('this account is pending please wait for admin approval')]);
               }
               elseif(Auth::guard('vendor')->user()->status==0){
                   return $this->validationFailure(errors:['message'=>__('this account is blocekd please contact with admin')]);
               }
               elseif(Auth::guard('vendor')->user()->status==3){
                   return $this->validationFailure(errors:['message'=>__('this account is rejected please create new account or contact with admin')]);
               }

           }
           else{
               $comment=LiveComment::create([
                   'vendor_id' => Auth::guard('vendor')->user()->id,
                   'live_id' => $data['live_id'],
                   'rate' => $data['live_id'],
                   'description_ar' => request('comment'),
                   'description_en' => request('comment'),
                   ]);
               return $this->success(data:$comment);
         }
       } else{
           return $this->validationFailure(errors:['message'=>__('must be login to create comment')]);

       }
       }


       public function store(Request $request)
       {
           $data= $request->validate([
               'payment_method' => 'required',
               'live_id' => 'required|exists:lives,id',

           ]);

           $live=Live::find($data['live_id']);
           $order = Order::create([
               'vendor_id' => Auth::user()->id,
               'live_id' =>$data['live_id'],
               'is_paid' => false,
               'type' => 'live',
               'total_price' => $live->price,
               'payment_method' => $data['payment_method'],
           ]);
           return $this->success(data:$order);
       }

       public function comments($live_id)
       {
           // Fetch the live instance with comments and vendors eagerly loaded
           $commentsQuery = LiveComment::with('vendor')->where('live_id', $live_id);

           // Paginate comments
           $comments = $commentsQuery->paginate(5);

           // Total comments count
           $totalCommentsCount = $commentsQuery->count();

           // Calculate average rate (if there are comments)
           $averageRate = $totalCommentsCount > 0
               ? round($commentsQuery->avg('rate'), 2)
               : 0;

           // Rate count breakdown (percentage per rating)
           $ratePercentages = collect([1, 2, 3, 4, 5])->map(function ($rate) use ($commentsQuery, $totalCommentsCount) {
               $rateCount = (clone $commentsQuery)->where('rate', $rate)->count();
               return [
                   'rate' => $rate,
                   'percentage' => $totalCommentsCount > 0
                       ? round(($rateCount / $totalCommentsCount) * 100, 2)
                       : 0
               ];
           });

           // Transform the paginated comments
           $transformedComments = $comments->through(function ($comment) {
               return [
                   'id' => $comment->id,
                   'rate' => $comment->rate,
                   'description' => $comment->description,
                   'client' => $comment->vendor->name,
                   'client_image' => getImagePathFromDirectory($comment->vendor->image, 'ProfileImages'),
                   'created_at' => $comment->created_at->format('Y-m-d'),
               ];
           });

           // Prepare final response data
           $responseData = [
               'comments_count' => $totalCommentsCount,
               'average_rate' => $averageRate,
               'comments' => $transformedComments,
               'rate_count' => $totalCommentsCount,
               'rate_percentage' => $ratePercentages,
           ];

           // Return final result — removed second return (this one is sufficient)
           return $this->success(data: $responseData);
       }



}
