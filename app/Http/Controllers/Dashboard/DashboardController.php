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

         $bestSellingBooks = DB::table('orders')
            ->select('book_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->whereNotNull('book_id')
            ->groupBy('book_id')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

         $bestSellingCourses = DB::table('orders')
            ->select('course_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->whereNotNull('course_id')
            ->groupBy('course_id')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        $bestSellingConsultations = DB::table('orders')
            ->select('consultaion_id', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
            ->whereNotNull('consultaion_id')
            ->groupBy('consultaion_id')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();



        return view('dashboard.index', compact('totalOrders',   'totalVendors','totalbooks','totalcourses','bestSellingBooks','bestSellingCourses','bestSellingConsultations'));
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
