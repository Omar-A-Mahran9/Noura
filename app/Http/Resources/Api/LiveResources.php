public function toArray($request)
{
    $isFree = $this->price == 0;
    $haveDiscount = $this->have_discount && $this->discount_price > 0;
    $priceAfterDiscount = $haveDiscount ? $this->discount_price : $this->price;
    $discountPercentage = 0;

    if ($haveDiscount && $this->price > 0) {
        $discountValue = $this->price - $this->discount_price;
        $discountPercentage = round(($discountValue / $this->price) * 100, 2);
    }

    return [
        'id' => $this->id,
        'image' => getImagePathFromDirectory($this->main_image, 'lives'),
        'title' => $this->title,
        'description' => $this->description,
        'price' => $this->price,
        'price_after_discount' => $priceAfterDiscount,
        'is_free' => $isFree,
        'have_discount' => $haveDiscount,
        'discount_percentge' => $discountPercentage,

        'day_date' => $this->day_date ?? null,
        'from' => $this->from ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)->format('h:i A') : null,
        'to'   => $this->to ? \Carbon\Carbon::createFromFormat('H:i:s', $this->to)->format('h:i A') : null,
        'previwe_video' => $this->video_url,

        'live_start_durin' => $this->from && $this->to
            ? \Carbon\Carbon::createFromFormat('H:i:s', $this->from)
                ->diff(\Carbon\Carbon::createFromFormat('H:i:s', $this->to))
                ->format('%h hours %i minutes')
            : null,

        'duration_minutes' => $this->duration_minutes,
        'publish' => $this->publish,
        'created_at' => $this->created_at->format('Y-m-d'),
    ];
}
