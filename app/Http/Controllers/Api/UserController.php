<?php

namespace App\Http\Controllers\Api;

use App\Enums\CarStatus;
use App\Models\Car;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Resources\CarResourse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Site\UpdateUserController;
use App\Http\Resources\Api\UserResource;
use App\Http\Resources\OrderResource;
use App\Models\CarImage;
use App\Models\CarModel;
use App\Models\ChatGroup;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\SettingOrderStatus;
use App\Models\Vendor;
use App\Rules\NotNumbersOnly;
use App\Rules\PasswordValidate;
use Carbon\Carbon;
use DB;
use GrahamCampbell\ResultType\Success;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Support\Facades\Config;

use function PHPUnit\Framework\isEmpty;

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

    // Fetch chat groups where the vendor is associated
    $groups = ChatGroup::whereHas('vendors', function ($query) use ($vendorId) {
        $query->where('vendors.id', $vendorId);
    })
    ->with(['vendors' => function ($query) {
        $query->select('id', 'name', 'image', 'last_seen'); // Select only necessary fields
    }])
    ->orderBy('created_at', 'desc')
    ->get();

    // Map the groups to the required structure
    return response()->json([
        'success' => true,
        'groups' => $groups->map(function ($group) {
            return [
                'id' => $group->id,
                'title' => $group->name_en, // You might want to check if `name_en` is the correct field
                'created_at' => $group->created_at->toDateTimeString(),
                'vendors' => $group->vendors->map(function ($vendor) {
                    return [
                        'id' => $vendor->id,
                        'name' => $vendor->name,
                        'image' => getImagePathFromDirectory($vendor->image, 'Vendors'), // Assuming the function exists for image path
                        'last_seen' => $vendor->last_seen,
                        'status' => Carbon::parse($vendor->last_seen)->diffInMinutes(now()) < 5 ? 'online' : 'offline',
                    ];
                }),
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


}
