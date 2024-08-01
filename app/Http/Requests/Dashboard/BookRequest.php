<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function messages()
    {
        return [
            'title.required'        => 'العنوان مطلوب',
            'publish_date.required' => 'تاريخ النشر مطلوب',
            'pages.required'        => 'عدد الصفحات مطلوب',
            'image.required'        => 'الصورة مطلوبة',
            'file.required'         => 'الملف مطلوب',
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
                    'title_ar'         => 'required|string|max:255',
                    'title_en'         => 'required|string|max:255',
                    'author_ar'        => 'required|string|max:255',
                    'author_en'        => 'required|string|max:255',
                    'publisher_ar'     => 'required|string|max:255',
                    'publisher_en'     => 'required|string|max:255',
                    'edition_ar'       => 'required|string|max:255',
                    'edition_en'       => 'required|string|max:255',
                    'physical_desc_ar' => 'required',
                    'physical_desc_en' => 'required',
                    'desc_ar'          => 'required',
                    'desc_en'          => 'required',
                    'image'            => 'required|image|mimes:jpeg,png,jpg',
                    'file'             => 'required|mimes:pdf,docx',
                ];
                break;

            case 'PATCH':
                return [
                    'title_ar'         => 'required|string|max:255',
                    'title_en'         => 'required|string|max:255',
                    'author_ar'        => 'required|string|max:255',
                    'author_en'        => 'required|string|max:255',
                    'publisher_ar'     => 'required|string|max:255',
                    'publisher_en'     => 'required|string|max:255',
                    'edition_ar'       => 'required|string|max:255',
                    'edition_en'       => 'required|string|max:255',
                    'physical_desc_ar' => 'required',
                    'physical_desc_en' => 'required',
                    'desc_ar'          => 'required',
                    'desc_en'          => 'required',
                    'image'            => 'nullable|image|mimes:jpeg,png,jpg',
                    'file'             => 'nullable|mimes:pdf,docx',
                ];
                break;
        }
    }
}
