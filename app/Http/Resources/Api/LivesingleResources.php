<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class LivesingleResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'image' => getImagePathFromDirectory($this->main_image, 'lives'),
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'day_date' => $this->day_date ? $this->day_date : null,
        'from' => $this->from ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)->format('h:i') . ( \Carbon\Carbon::createFromFormat('H:i:s', $this->from)->format('A') === 'AM' ? ' صباحًا' : ' مساءً') : null,
'to'   => $this->to   ? \Carbon\Carbon::createFromFormat('H:i:s', $this->to)->format('h:i')   . ( \Carbon\Carbon::createFromFormat('H:i:s', $this->to)->format('A') === 'AM' ? ' صباحًا' : ' مساءً')   : null,

            'previwe_video' => $this->video_url,
            'live_start_durin' => $this->from && $this->to
                ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)
                    ->diff(\Carbon\Carbon::createFromFormat('H:i:s', $this->to))
                    ->format('%d days %h hours %i minutes %s seconds')
                : null,

            'duration_minutes' => $this->duration_minutes,
            'publish' => $this->publish,



            'created_at' => $this->created_at->format('Y-m-d'),
            'book_consultation'=>    [[
                'title' => 'Consultation',
                'image' => getImagePathFromDirectory('test', 'Groups'),
                'description_ar' => 'Consultation description',

            ],
            [
                'title' => 'Consultation',
                'image' => getImagePathFromDirectory('test', 'Groups'),
                'description_ar' => 'Consultation description',

            ],
            [
                'title' => 'Consultation',
                'image' => getImagePathFromDirectory('test', 'Groups'),
                'description_ar' => 'Consultation description',

            ]],
                'agenda' => $this->agenda->map(function ($item) {
                    return [
                        'title' => $item['title'] ?? '',
                        'description' => $item['description'] ?? '',
                        'start_time' => isset($item['start_time']) ? date('h:i A', strtotime($item['start_time'])) : '',
                        'end_time' => isset($item['end_time']) ? date('h:i A', strtotime($item['end_time'])) : '',

                    ];
                }),

            // Assigned specialist (employee)
            'specialist' => $this->specilist ? [
                'id' => $this->specilist->id,
                'name' => $this->specilist->name,
                'description' => $this->specilist->description,
                'image' => getImagePathFromDirectory($this->specilist->image, 'employees'),
            ] : null,

            // If comments are implemented for lives too (optional)
            'comments_count' => $this->comments?->count() ?? 0,

          // Paginate comments
          'comments' => $this->comments()->paginate(5)->through(function ($comment) {
            return [
                'id' => $comment->id,
                'live_id' => $comment->live_id,
                'rate' => $comment->rate,
                'vendor_id' => $comment->vendor_id,
                'description' => $comment->description,
                'vendor' => [
                    'id' => $comment->vendor->id,
                    'name' => $comment->vendor->name,
                    'image' => getImagePathFromDirectory($comment->vendor->image, 'vendors'),
                ],
                'created_at' => $comment->created_at->format('Y-m-d'),
            ];
        }),

            // Optional rating stats if you have them
            'rate_count' => $this->comments?->count() ?? 0,

            'rate_percentage' => collect([1, 2, 3, 4, 5])->map(function ($rate) {
                $totalComments = $this->comments?->count() ?? 0;
                $rateCount = $this->comments?->where('rate', $rate)->count() ?? 0;
                return [
                    'rate' => $rate,
                    'percentage' => $totalComments > 0 ? round(($rateCount / $totalComments) * 100, 2) : 0
                ];
            }),

        ];
    }
}
