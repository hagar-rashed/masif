<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class JobApplicationRequest extends FormRequest
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
            'name'  => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|digits_between:9,14',
            'file'  => 'required|mimes:png,jpg,pdf'
        ];
    }
}
