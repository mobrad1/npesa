<?php

namespace Modules\Admin\Http\Requests;

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
            'middle_name' => ['string','nullable'],
            'last_name' => ['string','nullable'],
            'email' => ['email','nullable'],
            'gender' =>['string','nullable'],
            'settings_push_notification' => ['boolean'],
            'settings_notification' => ['boolean'],
            'settings_email_notifications' => ['boolean'],
            'settings_general' => ['boolean'],
            'marital_status' => ['string','nullable'],
            'date_of_birth' => ['date','nullable'],
            'latitude' => ['string','nullable'],
            'longitude' => ['string','nullable'],
            'state' => ['string','nullable'],
            'area' => ['string','nullable'],
            'city' => ['string','nullable'],
            'address' => ['string','nullable'],
            'channel' => ['string','nullable']
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
