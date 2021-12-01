<?php

namespace Modules\Business\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankAccountRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_name'=> ['required', 'string'],
            'account_number'=> ['required', 'string'],
            'bank_code'=> ['required', 'string']
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
        $data = $this->validated();
        $business = $this->user('business');
        $data['payable_type'] = get_class($business);
        $data['payable_id'] = $business->id;
        return $data;
    }
}
