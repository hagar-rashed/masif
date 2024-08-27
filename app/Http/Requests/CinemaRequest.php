<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CinemaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
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
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',                  
           'image_url' => 'nullable|image', 
           'latitude' => 'required|numeric',
           'longitude' => 'required|numeric',
           'details' => 'nullable|string',           
           'rating' => 'required|numeric|min:1|max:10',                    
        ];
    }
}