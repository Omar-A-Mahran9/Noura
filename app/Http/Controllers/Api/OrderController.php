<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateOrderRequest;
use App\Models\Book;
use App\Models\Consultaion;
use App\Models\Course;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(CreateOrderRequest $request)
    {
        $totalPrice = 0;
        $type = null;

        if ($request->book_id) {
            $book = Book::find($request->book_id);
            $totalPrice += $book->price;
            $type = 'book';
        }

        if ($request->course_id) {
            $course = Course::find($request->course_id);
            $totalPrice += $course->price;
            $type = 'course';
        }

        if ($request->consultation_id) {
            $consultation = Consultaion::find($request->consultation_id);
            $totalPrice += $consultation->price;
            $type = 'consultation';
        }

        $order = Order::create([
            'vendor_id' => Auth::user()->id,
            'book_id' => $request->book_id,
            'course_id' => $request->course_id,
            'consultaion_id' => $request->consultation_id,
            'total_price' => $totalPrice,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'type' => $type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully!',
            'order' => $order
        ], 201);
    }

}
