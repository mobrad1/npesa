<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone'=> ['required', 'string', 'exists:businesses'],
            'pin'=> ['required', 'string', 'min:4']
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
