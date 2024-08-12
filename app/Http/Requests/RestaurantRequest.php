<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
           'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
        ];
    }
}