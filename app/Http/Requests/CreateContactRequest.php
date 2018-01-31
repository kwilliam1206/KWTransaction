<?php

namespace KW\Transactions\Http\Requests;

use KW\Transactions\Http\Requests\Request;
use KW\Transactions\Models\PhoneType;

class CreateContactRequest extends Request
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            //'primary_phone' => 'required|numeric'
        ];

        $primary_phone = $this->get('primary_phone');
        if (is_numeric($primary_phone)) {
            $phoneType = PhoneType::where('id', $primary_phone)->first();
            $name = $phoneType->rawname . '_phone';

            //TODO add phone number regex pattern
            $rules[$name] = 'required';
        }

        return $rules;
    }
}
