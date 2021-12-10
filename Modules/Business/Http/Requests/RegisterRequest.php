<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'business_name'=> ['required', 'string'],
            'email'=> ['required', 'email', 'unique:businesses'],
            'password'=> ['required', 'string', 'min:5', 'confirmed']
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
