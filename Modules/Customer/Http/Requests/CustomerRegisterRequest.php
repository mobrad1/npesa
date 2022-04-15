<?php

namespace Modules\Customer\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Customer\Entities\Customer;

class CustomerRegisterRequest extends FormRequest
{
    use PasswordValidationRules;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            "first_name" => ['required','string'],
            "middle_name" => ['required','string'],
            "last_name" => ['required','string'],
            "email" => ['string','email'],
            "gender" => ["string"],
            "phone" => ['required',Rule::unique(Customer::class)],
            "channel" => ['required','string'],
            "pin" => $this->passwordRules()
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
