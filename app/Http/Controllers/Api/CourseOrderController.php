<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Course;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class CourseOrderController extends Controller
{
    public function store(Request $request)
    {
        $data= $request->validate([
             'payment_method' => 'required',
            'course_id' => 'required|exists:books,id',

        ]);

        $course=Course::find($data['course_id']);
        $order = Order::create([
            'vendor_id' => Auth::user()->id,
            'course_id' =>$data['course_id'],
            'is_paid' => false,
            'type' => 'course',
            'total_price' => $course->price,
            'payment_method' => $data['payment_method'],
        ]);
    }

}
