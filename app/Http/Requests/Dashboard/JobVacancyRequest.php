<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class JobVacancyRequest extends FormRequest
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
                    'name_ar' => 'required|string|max:255',
                    'name_en' => 'required|string|max:255',
                    'desc_ar' => 'required',
                    'desc_en' => 'required',
                ];
                break;

            case 'PATCH':
                return [
                    'name_ar' => 'required|string|max:255',
                    'name_en' => 'required|string|max:255',
                    'desc_ar' => 'required',
                    'desc_en' => 'required',
                ];
                break;
        }
    }
}
