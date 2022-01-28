<?php

namespace Modules\Customer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'first_name' => ['string'],
            'last_name' => ['string'],
            'phone' => ['string'],
            'gender' =>['string'],
            'date_of_birth' => ['date'],
            'marital_status' => ['string'],
            'state' => ['string'],
            'area' => ['string'],
            'city' => ['string'],
            'email' => ['email']
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
}
