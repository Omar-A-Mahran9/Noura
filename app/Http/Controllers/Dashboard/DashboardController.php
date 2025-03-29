<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Car;
 use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private static array $takenColors    = [];
    private static int   $lastColorIndex = 0;

    public function index()
    {
        // Dummy data for monthly rates
        $carsMonthlyRate = [
            'January' => 10, 'February' => 15, 'March' => 20,
            'April' => 18, 'May' => 25, 'June' => 30,
        ];

        $ordersMonthlyRate = [
            'January' => 8, 'February' => 12, 'March' => 16,
            'April' => 14, 'May' => 22, 'June' => 28,
        ];

        // Dummy orders type percentage data
        $ordersTypesPercentage = collect([
            ['label' => 'New Order', 'data' => 40, 'color' => '#FF5733'],
            ['label' => 'Processing', 'data' => 30, 'color' => '#33FF57'],
            ['label' => 'Completed', 'data' => 50, 'color' => '#3357FF'],
        ]);

        // Dummy car brands percentage data
        $carBrandsPercentage = collect([
            ['label' => 'Toyota', 'data' => 25, 'color' => '#FFA07A'],
            ['label' => 'Ford', 'data' => 30, 'color' => '#20B2AA'],
            ['label' => 'Honda', 'data' => 35, 'color' => '#9370DB'],
        ]);

        // Dummy car orders brands percentage data
        $carOrdersBrandsPercentage = collect([
            ['label' => 'Toyota', 'data' => 15, 'color' => '#DC143C'],
            ['label' => 'Ford', 'data' => 22, 'color' => '#228B22'],
            ['label' => 'Honda', 'data' => 18, 'color' => '#8B0000'],
        ]);

        // Simulate the swap array elements function
        if (count($ordersTypesPercentage) > 1) {
            $ordersTypesPercentage = $this->swapArrayElements($ordersTypesPercentage->toArray(), 0);
        }

        return view('dashboard.index', compact(
            'carsMonthlyRate',
            'ordersMonthlyRate',
            'ordersTypesPercentage',
            'carBrandsPercentage',
            'carOrdersBrandsPercentage'
        ));
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
