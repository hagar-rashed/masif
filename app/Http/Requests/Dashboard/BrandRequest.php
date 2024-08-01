<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            case 'PATCH':
                return [
                    'name_ar' => 'nullable|string|max:255',
                    'name_en' => 'nullable|string|max:255',
                    'desc_ar' => 'nullable',
                    'desc_en' => 'nullable',
                    'media'   => 'nullable|mimes:png,jpg,mp4',
                    'image'   => 'nullable|image|mimes:png,jpg',
                    // 'link'  => 'required|url',
                ];
                break;

            default:
                return [
                    'name_ar' => 'nullable|string|max:255',
                    'name_en' => 'nullable|string|max:255',
                    'desc_ar' => 'nullable',
                    'desc_en' => 'nullable',
                    'media'   => 'required|mimes:png,jpg,mp4',
                    'image'   => 'required|image|mimes:png,jpg',
                    // 'link'  => 'required|url',
                ];
                break;
        }
    }
}
