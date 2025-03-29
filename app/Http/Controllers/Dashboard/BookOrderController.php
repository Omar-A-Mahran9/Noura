<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class BookOrderController extends Controller
{
    public function order(Request $request)
    {
           $this->authorize('view_orders');

        if ($request->ajax())
        {
                $data = getModelData(model: new Order(),relations: ['vendor' => ['id', 'name','phone']], andsFilters: [['type', '=', 'book']]);


            return response()->json($data);
        }

        return view('dashboard.orders.index');
    }

    public function order_show($id)
    {
        $this->authorize('view_orders'); // Authorization check

        // Fetch order with all related data
        $order = Order::with([
            'vendor:id,name,phone',
            'book:id,title_ar,title_en',
            'course:id,name_ar,name_en',
            'consultation:id,title_ar,title_en',
            'consultaionType:id,name_ar,name_en',
            'consultaionSchedual:id,time,date',
            'quiz:id,name_ar,name_en',
            'quiz.questions.answers', // Include questions and answers
        ])->findOrFail($id);

        // Fetch vendor answers related to this quiz and client
        $vendorAnswers = $order->quiz
        ? VendorAnswers::where('quiz_id', $order->quiz->id)
            ->where('vendor_id', $order->vendor_id)
            ->get()
        : collect(); // Return an empty collection if no quiz is found


        return view('dashboard.orders.show', compact('order', 'vendorAnswers'));
    }
}
