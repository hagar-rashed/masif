<?php

namespace App\Http\Requests\Dashboard;

use App\Rules\YouTubeUrl;
use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
{
    public function messages()
    {
        return [
            'title.required'        => 'العنوان مطلوب',
            'desc.required'         => 'الوصف مطلوب',
            'publish_date.required' => 'تاريخ النشر مطلوب',
            'url.required'          => 'رابط الفيديو مطلوب',
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
        return [
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'desc_ar'  => 'required',
            'desc_en'  => 'required',
            'url'      => ['required', new YouTubeUrl],
        ];
    }
}
