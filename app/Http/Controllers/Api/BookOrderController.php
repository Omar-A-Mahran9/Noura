<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class BookOrderController extends Controller
{
    public function store(Request $request)
    {
        $data= $request->validate([
             'payment_method' => 'required',
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|numeric|min:1',
            'type_of_book' => 'required|in:hard_copy,E-book', // Ensure valid enum values
        ]);

        $book=Book::find($data['book_id']);
        $order = Order::create([
            'vendor_id' => Auth::user()->id,
            'book_id' =>$data['book_id'],
            'is_paid' => false,
            'quantity' => $data['quantity'],
            'type' => 'book',
            'total_price' => $book->price,
            'payment_method' => $data['payment_method'],
        ]);
    }

}
