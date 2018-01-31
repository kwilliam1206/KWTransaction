<?php

namespace KW\Transactions\Http\Requests;

use KW\Transactions\Http\Requests\Request;
use Auth;

class UpdateTransactionRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->get('approve')) {
            return Auth::user()->can('approve_transaction');
        } else if ($this->get('reject')) {
            return Auth::user()->can('approve_transaction');
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // TODO ADD rules for transaction
        $rules = [
        ];

        return $rules;
    }
}
