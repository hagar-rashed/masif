<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CafeRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'opening_time_from' => 'required',
            'opening_time_to' => 'required',           
           'image_url' => 'nullable|url|ends_with:jpg,jpeg,png',
           'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
           'description' => 'nullable|string',
           'phone' => 'nullable|string|max:15',
           'rating' => 'required|integer|min:1|max:5',
           'delivery_time' => 'required|string|max:255',
           'busy_rate' => 'nullable|array', // Validate as array
           'busy_rate.*.time_from' => 'required_with:busy_rate|string',
           'busy_rate.*.time_to' => 'required_with:busy_rate|string',
           'busy_rate.*.percentage' => 'required_with:busy_rate|integer|min:0|max:100',
           
        ];
    }
}