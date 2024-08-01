<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ScrapRequest extends FormRequest
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
        switch (request()->method()) {
            case 'POST':
                return [
                    'desc_ar'      => 'required',
                    'desc_en'      => 'required',
                    'image'        => 'required|image|mimes:jpeg,png,jpg',
                ];
                break;

            case 'PATCH':
                return [
                    'desc_ar'      => 'required',
                    'desc_en'      => 'required',
                    'image'        => 'nullable|image|mimes:jpeg,png,jpg',
                ];
                break;
        }
    }
}
