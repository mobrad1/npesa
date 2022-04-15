<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyAirtimeRequest extends FormRequest
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
            "mobile_number" => ["required"],
            "amount" => ["required"],
            "pin" => ["required"],
            "channel" => ["required"],
            "airtime_provider" => ["required"]
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
