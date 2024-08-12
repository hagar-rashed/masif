<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantBookingRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'mobile_number' => 'required|digits:11',
            'appointment_time' => 'required|date_format:Y-m-d H:i:s',
            'number_of_individuals' => 'required|in:1-3,4-6,6-8',
            'payment_method' => 'required|in:cash,wallet,credit/debit/ATM', // Added payment method validation
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Full name is required.',
            'mobile_number.required' => 'Mobile number is required.',
            'mobile_number.digits' => 'Mobile number must be 11 digits.',
            'appointment_time.required' => 'Appointment time is required.',
            'appointment_time.date_format' => 'Appointment time must be in the format YYYY-MM-DD HH:MM:SS.',
            'number_of_individuals.required' => 'Number of individuals is required.',
            'number_of_individuals.in' => 'Number of individuals must be one of the following: 1-3, 4-6, 6-8.',
            'payment_method.required' => 'Payment method is required.',
            'payment_method.in' => 'Payment method must be one of the following: cash, wallet, credit/debit/ATM.',
        ];
    }
}