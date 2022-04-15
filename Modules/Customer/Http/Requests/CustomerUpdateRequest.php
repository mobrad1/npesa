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
            'middle_name' => ['string'],
            'last_name' => ['string'],
            'email' => ['email'],
            'phone' => ['string'],
            'gender' =>['string'],
            'settings_push_notification' => ['boolean'],
            'settings_notification' => ['boolean'],
            'settings_email_notifications' => ['boolean'],
            'settings_general' => ['boolean'],
            'marital_status' => ['string'],
            'date_of_birth' => ['date'],
            'latitude' => ['string'],
            'longitude' => ['string'],
            'state' => ['string'],
            'area' => ['string'],
            'city' => ['string'],
            'address' => ['string'],
            'channel' => ['string']
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
