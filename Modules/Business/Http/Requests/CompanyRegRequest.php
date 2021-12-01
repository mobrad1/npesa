<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRegRequest extends FormRequest
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
            'reg_type'=> ['required', 'string'],
            'reg_number'=> ['required', 'string'],
            'reg_file'=> ['required', 'file']
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
