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
         ->select(
             'books.id',
             'books.title_en', // Correct column name
             'books.title_ar', // Correct column name
             DB::raw('COUNT(*) as total_sold'),
             DB::raw('SUM(orders.total_price) as total_revenue')
         )
         ->join('books', 'orders.book_id', '=', 'books.id')
         ->whereNotNull('orders.book_id')
         ->groupBy('books.id', 'books.title_en', 'books.title_ar')
         ->orderByDesc('total_sold')
         ->limit(3)
         ->get();


         $bestSellingCourses = DB::table('orders')
         ->select('course_id', DB::raw('COUNT(*) as total_sold'), DB::raw('SUM(total_price) as total_revenue'))
         ->whereNotNull('course_id')
         ->groupBy('course_id','course.name_ar', 'course.name_en')
         ->orderByDesc('total_sold')
         ->limit(3)
         ->get();


         $bestSellingConsultations = DB::table('orders')
         ->select(
             'consultaion.id',
             'consultaion.title_en',
             'consultaion.title_ar',
             'consultaion_type.name_en as consultaion_type_name', // Correct column name
             DB::raw('COUNT(*) as total_sold'),
             DB::raw('SUM(orders.total_price) as total_revenue')
         )
         ->join('consultaion', 'orders.consultaion_id', '=', 'consultaion.id')
         ->join('consultaion_type', 'consultaion.consultaion_type_id', '=', 'consultaion_type.id')
         ->whereNotNull('orders.consultaion_id')
         ->groupBy('consultaion.id', 'consultaion.title_en', 'consultaion.title_ar', 'consultaion_type.name_en') // Match selected fields
         ->orderByDesc('total_sold')
         ->limit(3)
         ->get();




        return view('dashboard.index', compact('totalOrders',   'totalVendors','totalbooks','totalcourses','bestSellingBooks','bestSellingCourses','bestSellingConsultations'));
    }




}
