<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\NotNumbersOnly;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreLivesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return abilities()->contains('create_live');
    }

    public function rules()
    {
        $discountPrice = $request['discount_price'] ?? 0;
        $price         = $request['price'] ?? 0;


        return [
            'title_ar' => ['required', 'string', 'max:255', 'unique:lives,title_ar', new NotNumbersOnly()],
            'title_en' => ['required', 'string', 'max:255', 'unique:lives,title_en', new NotNumbersOnly()],
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'price' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) use ($discountPrice) {
                    if ($value < 0) {
                        $fail('The price cannot be negative.');
                    }
                    if ($value > 0 && $value <= $discountPrice) {
                        $fail('The price must be greater than the discount price.');
                    }
                }
            ],
            'have_discount' => ['nullable'],
            'discount_price' => [
                'required_with:have_discount',
                'nullable',
                'numeric',
                'not_in:0',
                function ($attribute, $value, $fail) {
                    $price = request()->input('price', 0);
                    if ($value >= $price) {
                        $fail(__('Discount price must be smaller than the price.'));
                    }
                }
            ],
            'assign_to' => ['required', 'string'],
            'main_image' => ['required', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'video_url' => ['required', 'url', 'string', 'max:255'],
            'day_date' => ['required', 'date'],
            'from' => ['required', 'date_format:H:i'],
            'to' => ['required', 'date_format:H:i', 'after:from'],
        ];
    }

}
