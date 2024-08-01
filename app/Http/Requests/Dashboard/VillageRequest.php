<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class VillageRequest extends FormRequest
{
   public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'location_ar' => 'required|string|max:255',
            'location_en' => 'required|string|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',                    
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'services_ar' => 'required|string|max:255',
            'services_en' => 'required|string|max:255',
            'owner_name_ar' => 'required|string|max:255',
            'owner_name_en' => 'required|string|max:255',
            'desc_ar' => 'required|string|max:255',
            'desc_en' => 'required|string|max:255',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',

        ];
    }
}
