<?php

namespace Modules\Admin\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Admin\Entities\Admin;

class AdminRegisterRequest extends FormRequest
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
            "last_name" => ['required','string'],
            "email" => ['string','email'],
            "gender" => ["string"],
            "phone" => ['required',Rule::unique(Admin::class)],
            "pin" => $this->passwordRules(),
            "role" => ['string','nullable']
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
