<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessCreateRequest extends FormRequest
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
            "business_name" => ["string"],
            "parent_id" => ["string","nullable"],
            'phone' => ['required', 'min:11', 'unique:businesses'],
            'pin'=> ['required', 'string', 'min:4', 'confirmed'],
            "category_id" => ["string","nullable"],
            "address" => ["string","nullable"],
            "email" => ["email","string","nullable"],
            "contact_person_name" => ["string","nullable"],
            "contact_person_address" =>["string","nullable"],
            "contact_person_email" => ["string","nullable"],
            "contact_person_phone" => ["string","nullable"],
            "latitude" =>["string","nullable"],
            "longitude" => ["string","nullable"],
            "state" => ["string","nullable"],
            "city" => ["string","nullable"],
            "area" => ["string","nullable"],
            "team_size" => ["int","nullable"],
            "reg_type" => ["string","nullable"],
            "reg_number" => ["string","nullable"]
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
