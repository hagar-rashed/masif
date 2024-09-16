<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'cinema_id' => 'required|exists:cinemas,id',
            'name' => 'required|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'genre' => 'required|string|max:255',
            'rating' => 'required|numeric|between:0,10',
            'description' => 'required|string',
            'certificate' => 'required|string|max:5',
            'runtime' => 'required|date_format:H:i',
            'release_year' => 'required|integer|digits:4',
            'director' => 'required|string|max:255',
            'cast' => 'required|string',
            'adult_price' => 'required|numeric|min:0',  
            'child_price' => 'required|numeric|min:0'
        ];
    }
}