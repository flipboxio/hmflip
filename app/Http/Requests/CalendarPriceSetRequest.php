<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalendarPriceSetRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'start_date'    => 'required',
            'end_date'      => 'required',
            'price'         => 'required|numeric|min:0',
            'minstay'       => 'nullable|integer|min:1',
            'status'        => 'required|in:Available,Not available',
        ];
    }

    public function messages()
    {
        return [
            'start_date.required'   => __('The start date is required.'),
            'end_date.required'     => __('The end date is required.'),
            'price.required'        => __('The price is required.'),
            'price.numeric'         => __('The price must be a number.'),
            'minstay.integer'       => __('The minimum stay must be an integer.'),
            'status.required'       => __('The status is required.'),
            'status.in'             => __('The selected status is invalid.'),
        ];
    }
}
