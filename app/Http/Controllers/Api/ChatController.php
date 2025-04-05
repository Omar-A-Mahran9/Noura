<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GroupResource;
use App\Http\Resources\Api\MessageResource;
use App\Models\ChatGroup;
use App\Models\Message;
use App\Models\MessageReceiver;
use App\Models\Vendor;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function joinToGroup($group_id)
    {
        $vendor_id = auth()->id(); // Get the authenticated vendor's ID

        // Find the chat group
        $chatGroup = ChatGroup::findOrFail($group_id);

        // Check if the vendor is already in the group
        if ($chatGroup->vendors()->where('vendor_id', $vendor_id)->exists()) {
            return response()->json(['message' => 'You are already in this group'], 400);
        }

        // Attach vendor to the group
        $chatGroup->vendors()->attach($vendor_id);

        return $this->success(
            message: "Joined the group successfully",
            data: [
                'group_id' => $chatGroup->id,
                'group_title' => $chatGroup->name_en, // or name_ar if needed
                'vendor_id' => $vendor_id,
                'vendor_name' => auth()->user()->name, // Use auth()->user() to get vendor's name
            ]
        );
    }
    public function leaveGroup($group_id)
    {
        $vendor_id = auth()->id(); // Get the authenticated vendor's ID

        // Find the chat group
        $chatGroup = ChatGroup::findOrFail($group_id);

        // Check if the vendor is part of the group
        if ($chatGroup->vendors()->where('vendor_id', $vendor_id)->exists()) {
            // Detach vendor from the chat group
            $chatGroup->vendors()->detach($vendor_id);

            return response()->json(['message' => 'Left the group successfully'], 200);
        }

        return response()->json(['message' => 'You are not part of this group'], 400);
    }

    public function groups()
    {
        $vendorId = auth()->id(); // Get the authenticated vendor's ID

        // Get all chat groups where the authenticated vendor has NOT joined yet
        $groups = ChatGroup::whereNotIn('id', function ($query) use ($vendorId) {
            // Subquery to fetch groups where the vendor is already part of the group
            $query->select('chat_group_id')
                  ->from('chat_group_vendor')
                  ->where('vendor_id', $vendorId);
        })
        ->paginate(10); // Using pagination instead of get()

        return $this->successWithPaginationResource(
            message: 'Available chat groups',
            data: GroupResource::collection($groups)
        );
    }




    public function group($id)
    {
        // Find the chat group with its vendors
        $chatGroup = ChatGroup::with('vendors')->find($id);

        if (!$chatGroup) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        return $this->success(
            message: "Group details retrieved successfully",
            data: [
                'group' => new GroupResource($chatGroup),
                'clients' => $chatGroup->vendors->map(function ($vendor) {
                    return [
                        'id' => $vendor->id, // Ensure the vendor has 'id' property
                        'name' => $vendor->name, // Assuming you have a 'name' field in the vendor
                        'image' =>  getImagePathFromDirectory($vendor->image, 'ProfileImages'),
                        'last_seen' => $vendor->last_seen,
                        'status' => $this->isOnline($vendor->last_seen) ? 'online' : 'offline',
                    ];
                }),
            ]
        );
    }

    private function isOnline($lastSeen)
    {
        if (!$lastSeen) return false;
        return Carbon::parse($lastSeen)->diffInMinutes(now()) < 1; // Online if last seen within 5 minutes
    }


    //----------------------------------------------------------------------------------------------------
    public function sendMessage(Request $request)
    {
         $request->validate([
            'chat_group_id' => 'required|exists:chat_groups,id',
            'message' => 'required|string',
            'file' => 'nullable|file|max:2048'
        ]);

        $sender = auth()->user(); // Get the authenticated vendor
        $chatGroup = ChatGroup::findOrFail($request->chat_group_id);

        // Upload file if exists
        $filePath = null;
                     // Check if the 'main_image' file is provided and update the image
        if ($request->hasFile('file')) {

           $filePath = uploadImage($request->file('file'), 'Messages');
        }

        // Save message
        $message = Message::create([
            'chat_group_id' => $chatGroup->id,
            'sender_id' => $sender->id,
            'message' => $request->message,
            'file' => $filePath
        ]);
        broadcast(new MessageSent($message))->toOthers();
         // Get all vendors in the group except sender
        $receivers = $chatGroup->vendors()->where('vendors.id', '!=', $sender->id)->pluck('vendors.id');

        // Attach receivers
        $message->receivers()->attach($receivers);
         return $this->success(
            'Message sent successfully',
               new MessageResource($message)
          );
    }


    // Fetch messages for a group
    public function getMessages($groupId)
    {
        $chatGroup = ChatGroup::findOrFail($groupId);

        $messages = Message::where('chat_group_id', $chatGroup->id)
            ->with(['vendor:id,name,image', 'receivers:id,name,image'])
            ->orderBy('created_at', 'asc')
            ->get();

        return $this->success(
            message: "Messages fetched successfully",
            data: MessageResource::collection($messages) // Wrap in resource collection
        );
    }

     // Mark messages as read
    public function markAsRead($message_id)
    {
        $vendor_id = Auth::guard('vendor')->id();

        $messageReceiver = MessageReceiver::where('message_id', $message_id)
            ->where('receiver_id', $vendor_id)
            ->first();

        if ($messageReceiver) {
            $messageReceiver->update(['read_at' => now()]);
             return $this->success(
                message: 'Message marked as read'
            );
        }

        return response()->json(['message' => 'Message not found'], 404);

    }

}
