<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class TalkRequest extends FormRequest
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
            'name_ar'      => 'required|string|max:255',
            'name_en'      => 'required|string|max:255',
            'job_title_ar' => 'required|string|max:255',
            'job_title_en' => 'required|string|max:255',
            'desc_ar'      => 'required|string',
            'desc_en'      => 'required|string',
        ];
    }
}
