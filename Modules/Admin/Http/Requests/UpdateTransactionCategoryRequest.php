<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionCategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["string"],
            "code" => ["string","nullable"],
            "user_type" => ["string","nullable"],
            "commission_amount" => ["nullable"],
            "commission_percentage" => ["nullable"],
            "description" => ["string","nullable"]
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
