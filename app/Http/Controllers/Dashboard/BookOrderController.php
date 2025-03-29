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

        return view('dashboard.Bookorders.index');
    }

    public function order_show($id)
    {
        $this->authorize('view_orders'); // Authorization check

        // Fetch order with all related data
        $order = Order::with([
            'vendor:id,name,phone',
            'book:id,title_ar,title_en',
            'course:id,name_ar,name_en',
        ])->findOrFail($id);


        return view('dashboard.Bookorders.show', compact('order' ));
    }

    public function destroy(Request $request, $id)
    {
        $this->authorize('delete_articles');

        // Find the consultation with its schedules
        $consultaion = Consultaion::with('consultaionScheduals')->findOrFail($id);

        try {
            \DB::transaction(function () use ($consultaion) {
                // Delete related schedules first (if needed)
                $consultaion->consultaionScheduals()->delete();

                // Delete consultation
                $consultaion->delete();

                // Delete image
                deleteImage($consultaion->main_image, 'Consultation');
            });

            // Return JSON response if AJAX request
            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Consultation deleted successfully']);
            }

         } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error deleting consultation', 'error' => $e->getMessage()], 500);
            }

         }
    }
}
