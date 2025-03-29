<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Car;
use App\Models\Course;
use App\Models\Order;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $totalOrders = Order::count();
         $totalVendors = Vendor::count(); // Ensure this is defined
         $totalbooks = Book::count(); // Ensure this is defined
         $totalcourses = Course::count(); // Ensure this is defined


        return view('dashboard.index', compact('totalOrders',   'totalVendors','totalbooks','totalcourses'));
    }



    // Simulated swap function
    private function swapArrayElements(array $array, int $index)
    {
        if ($index < count($array) - 1) {
            $temp = $array[$index];
            $array[$index] = $array[$index + 1];
            $array[$index + 1] = $temp;
        }
        return collect($array);
    }
}
