<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessOwnerProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name'=> ['required', 'string'],
            'last_name'=> ['required', 'string'],
            'phone'=> ['required', 'string'],
            'is_registered'=> ['required', 'boolean'],
            'team_size'=> ['required', 'numeric']
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

    /**
     * Gets the sanitized input
     *
     * @return array
     */
    public function getSanitized():array
    {
        return $this->validated();
    }
}
