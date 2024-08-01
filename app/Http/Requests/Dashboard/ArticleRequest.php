<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function messages()
    {
        return [
            'title.required'        => 'العنوان مطلوب',
            'image.required'        => 'الصورة مطلوبة',
            'publish_date.required' => 'تاريخ النشر مطلوب',
        ];
    }

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
                    'title_ar'    => 'required|string|max:255',
                    'title_en'    => 'required|string|max:255',
                    'desc_ar'     => 'required',
                    'desc_en'     => 'required',
                    'category_id' => 'required',
                    'image'       => 'nullable|image|mimes:jpeg,png,jpg',
                ];
                break;

            case 'PATCH':
                return [
                    'title_ar'    => 'required|string|max:255',
                    'title_en'    => 'required|string|max:255',
                    'desc_ar'     => 'required',
                    'desc_en'     => 'required',
                    'category_id' => 'required',
                    'image'       => 'nullable|image|mimes:jpeg,png,jpg',
                ];
                break;
        }
    }
}
