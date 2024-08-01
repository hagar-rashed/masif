<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Update this based on your authorization logic
    }

    public function rules()
    {
        return [
            'location_en' => 'required|string|max:255',
            'location_ar' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',                    
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'owner_name_en' => 'required|string|max:255',
            'owner_name_ar' => 'required|string|max:255',
            'desc_en' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'booked' => 'required|boolean',
            'avilable_from' => 'required|date',
            'avilable_to' => 'nullable|date',
            'village_id' => 'required|exists:villages,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
        ];
    }
}
