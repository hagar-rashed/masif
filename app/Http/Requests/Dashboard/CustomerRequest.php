<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                    'image' => 'nullable|image|mimes:png,jpg',
                    'link'  => 'required|url',
                ];
                break;

            default:
                return [
                    'image' => 'required|image|mimes:png,jpg',
                    'link'  => 'required|url',
                ];
                break;
        }
    }
}
