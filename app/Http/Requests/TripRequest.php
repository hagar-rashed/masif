<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
{
    public function authorize()
    {
        // Set to true to allow all users to use this request.
        // You can implement authorization logic here if needed.
        return true;
    }

    public function rules()
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'location_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
            'desc_ar' => 'required|string|max:1000',
            'desc_en' => 'required|string|max:1000',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'duration' => 'required',
        ];
    }
}
