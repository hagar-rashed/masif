<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class QRCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'village_name' => 'required|string|max:255',
            'starting_date' => 'required|date',
            'expiration_date' => 'required|date|after_or_equal:starting_date',
           // 'duration' => 'required|integer|min:1',
            'code_type' => 'required|in:guest,owner,rental',
        ];

        switch ($this->method()) {
            case 'PATCH':
                $rules['email'] = 'required|email|unique:qrcodes,email,' . $this->route('qrcode');
                break;

            default:
                $rules['email'] = 'required|email|unique:qrcodes,email';
                break;
        }

        return $rules;
    }
}