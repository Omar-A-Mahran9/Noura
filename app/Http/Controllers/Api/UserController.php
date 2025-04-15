<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
 use App\Http\Resources\Api\UserResource;
use App\Http\Resources\OrderResource;

use App\Models\ChatGroup;
 use App\Models\Order;

use App\Models\Vendor;
use App\Rules\NotNumbersOnly;
use App\Rules\PasswordValidate;
use Carbon\Carbon;
use DB;
 use Illuminate\Validation\Rule;
class UserController extends Controller
{



    public function profile()
    {
        return $this->success(data: new UserResource(auth()->user()));
    }



    public function updateProfile(Request $request)
    {
        $vendor = Auth::user();

        // Validate only provided fields (before conversion)
        $validatedData = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                new NotNumbersOnly(),
                Rule::unique('vendors', 'name')->ignore($vendor->id),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('vendors')->ignore($vendor->id),
            ],
            'phone' => [
                'sometimes',
                'string',
                'regex:/^((\+|00)966|0)?5[0-9]{8}$/',
                Rule::unique('vendors')->ignore($vendor->id),
            ]
        ]);

        // Convert Arabic numbers AFTER validation
        if ($request->filled('phone')) {
            $validatedData['phone'] = convertArabicNumbers($validatedData['phone']);
        }

        // Update only the provided fields
        $vendor->update($validatedData);

        return $this->success(data: $vendor);
    }

    public function updateProfileImage(Request $request)
    {
        $vendor = Auth::user();

        // Validate the uploaded image
        $request->validate([
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Max 2MB
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists (excluding the default image)
            deleteImage($vendor->image,'ProfileImages');

            // Upload and save the new image
            $imageName = uploadImage($request->file('image'), 'ProfileImages');

            // Update the user's profile with the new image
            $vendor->update(['image' => $imageName]);
        }

        return $this->success(data:[
            'image_url' => getImagePathFromDirectory($vendor->image, 'ProfileImages'),
            'user' =>  new UserResource( $vendor)

        ]);
    }






    public function changPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'min:8', 'max:255', 'confirmed',new PasswordValidate()],
            'password_confirmation' => ['required','same:password'],
        ]);

        $user = auth()->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $errors = [
                'old_password' => [__('The old password is incorrect')],
                // 'another_key' => ['Another error message'],
            ];

            return $this->validationFailure(errors:  $errors);
        } else {
            $usser = Vendor::where('phone', $user->phone)->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return $this->success(data:$usser, message: __('Password updated successfully'));
    }


    public function myOrder(Request $request)
    {
        $vendorId = Auth::id(); // Get the logged-in vendor's ID

        // Paginate the orders, 5 per page
        $orders = Order::where('vendor_id', $vendorId)
            ->with(['book', 'course', 'consultation']) // Eager load related models
            ->orderBy('created_at', 'desc')
            ->paginate(5); // 👈 paginate instead of get()

        // Wrap paginated result in a resource collection
        $orderResource = OrderResource::collection($orders);

        return $this->successWithPaginationResource(message: 'My orders', data: $orderResource);
    }


    public function myCourse(Request $request)
{
    $vendorId = Auth::id(); // Get the logged-in vendor's ID

    // Fetch only orders that contain a course
    $orders = Order::where('vendor_id', $vendorId)
        ->whereNotNull('course_id') // Only include orders that have a course
        ->with('course') // Eager load the course data
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'courses' => $orders->map(fn($order) => [
            'id' => $order->course->id,
            'name' => $order->course->name,
            'image' => $order->course->name,

            'description' => $order->course->description,
            'price' => $order->course->price,
            'order_id' => $order->id,
            'payment_status' => $order->payment_status,
            'payment_method' => $order->payment_method,
            'created_at' => $order->created_at->toDateTimeString(),
        ])
    ], 200);
}
public function myBooks(Request $request)
{
    $vendorId = Auth::id(); // Get the logged-in vendor's ID

    // Fetch only orders that contain a book, paginated (5 per page)
    $orders = Order::where('vendor_id', $vendorId)
        ->whereNotNull('book_id') // Only include orders that have a book
        ->with('book') // Eager load the book data
        ->orderBy('created_at', 'desc')
        ->paginate(6); // Paginate orders, 5 per page

    // Transform the paginated orders
    $books = $orders->getCollection()->map(fn($order) => [
        'id' => $order->book->id,
        'title' => $order->book->title,
        'image' => getImagePathFromDirectory($order->book->image, 'books/images'), // Assuming there is an image column
    ])->values(); // Ensure the collection is indexed correctly after mapping

    // Replace the original collection with the transformed one
    $orders->setCollection($books);

    // Return the paginated response using your custom successWithPagination method
    return $this->successWithPagination(
        message: 'My books',
        data: $orders
    );
}

public function myGroups()
{
    $vendorId = auth()->id(); // Get the authenticated vendor's ID

    $groups = ChatGroup::whereHas('vendors', function ($query) use ($vendorId) {
        $query->where('vendors.id', $vendorId);
    })
    ->with(['vendors' => function ($query) {
        // Specify the table to avoid ambiguity
        $query->select('vendors.id', 'vendors.name', 'vendors.image', 'vendors.last_seen');
    }])
    ->orderBy('created_at', 'desc')
    ->get();

    return response()->json([
        'success' => true,
        'groups' => $groups->map(function ($group) {
            $onlineVendorsCount = $group->vendors->filter(function ($vendor) {
                return Carbon::parse($vendor->last_seen)->diffInMinutes(now()) < 5; // Check if the vendor is online
            })->count(); // Get the count of online vendors

            return [
                'id' => $group->id,
                'title' => $group->name,
                'image' => getImagePathFromDirectory($group->image, 'Groups'),
                'created_at' => $group->created_at->toDateTimeString(),
                'online_vendors' => $onlineVendorsCount, // Count of online vendors

            ];
        })
    ], 200);
}


public function myConsultation(Request $request)
{
    $vendorId = Auth::id(); // Get the logged-in vendor's ID

    // Query orders that have consultations
    $ordersQuery = Order::where('vendor_id', $vendorId)
        ->whereHas('consultation') // Ensure consultation exists
        ->with(['consultation', 'consultaionSchedual', 'consultaionType'])
        ->orderBy('created_at', 'desc');

    // Paginate results
    $orders = $ordersQuery->paginate(5); // 👈 5 per page

    // Transform paginated items
    $consultations = $orders->getCollection()->map(function ($order) {
        $scheduledDateTime = null;

        if ($order->consultaionSchedual) {
            $scheduledDateTime = Carbon::parse(
                $order->consultaionSchedual->date . ' ' . $order->consultaionSchedual->time
            );
        }

        return [
            'title' => $order->consultaionType->name ?? '',
            'type' => $order->consultaionType->name ?? '',
            'price' => $order->consultation->price,
            'status' => $scheduledDateTime && $scheduledDateTime->isPast()
                ? __('consultation ended')
                : __('consultation scheduled'),
            'schedule' => $order->consultaionSchedual ? [
                'date' => $order->consultaionSchedual->date,
                'time' => Carbon::parse($order->consultaionSchedual->time)->format('g:i A'),
                'zoom_join_url' => $order->consultaionSchedual->zoom_join_url,
            ] : null,
        ];
    });

    // Replace paginated items with transformed items
    $orders->setCollection($consultations);

    // Return with pagination response
    return $this->successWithPagination(message: 'My consultations', data: $orders);
}

public function myLive(Request $request)
{
    $vendorId = Auth::id(); // Get the logged-in vendor's ID

    // Fetch only orders that contain a live event, paginated (6 per page)
    $orders = Order::where('vendor_id', $vendorId)
        ->whereNotNull('live_id') // Only include orders that have a live event
        ->with('live') // Eager load the live event data
        ->orderBy('created_at', 'desc')
        ->paginate(6); // Paginate orders, 6 per page

    // Transform the paginated orders to include live event details
    $lives = $orders->getCollection()->map(fn($order) => [
        'id' => $order->live->id, // Access the live event's ID
        'title' => $order->live->title_ar, // Example: Get Arabic title, change to title_en if needed
        'description' => $order->live->description, // Example: Get Arabic title, change to title_en if needed
        'price' => $order->live->price, // Example: Get Arabic title, change to title_en if needed
        'image' => getImagePathFromDirectory($order->live->main_image, 'lives'), // Assuming the live event has a main image
        'date' => \Carbon\Carbon::parse($order->live->day_date)->format('Y-m-d'), // Format the live event's date
        'time' => \Carbon\Carbon::parse($order->live->from)->format('H:i A') . ' - ' . \Carbon\Carbon::parse($order->live->to)->format('H:i A'), // Format live event time range
    ])->values(); // Ensure the collection is indexed correctly after mapping

    // Replace the original collection with the transformed one
    $orders->setCollection($lives);

    // Return the paginated response using your custom successWithPagination method
    return $this->successWithPagination(
        message: 'My live events',
        data: $orders
    );
}


}
