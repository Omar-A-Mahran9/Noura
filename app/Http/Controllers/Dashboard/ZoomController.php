<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;

class ZoomController extends Controller
{
    public function generateSignature($meetingId)
    {
        // Zoom Web SDK requires the meeting ID and role (1 for host, 0 for participant)
        $apiKey = env('ZOOM_CLIENT_ID');
        $apiSecret = env('ZOOM_CLIENT_SECRET');
        $role = 0; // 0 for participant, 1 for host

        $timestamp = time() * 1000; // Current timestamp in milliseconds
        $expireTime = $timestamp + 5000; // Signature expiration time

        $data = [
            'apiKey' => $apiKey,
            'apiSecret' => $apiSecret,
            'meetingNumber' => $meetingId,
            'role' => $role,
            'iat' => $timestamp,
            'exp' => $expireTime,
        ];

        // Encode the data into a JWT signature
        $signature = base64_encode(json_encode($data));

        return response()->json([
            'signature' => $signature,
            'meeting_id' => $meetingId,
        ]);
}
}
