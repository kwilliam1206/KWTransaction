<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use KW\Transactions\Models\CustomFinancialAttribute;
use KW\Transactions\Models\Office;
use KW\Transactions\Models\User;
use Log;
use Auth;

class CustomFinancialAttributeController extends Controller
{
    /**
     * Upsert a custom financial attribute.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upsert(Request $request)
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        //Log::info(json_encode($request->all()));

        $this->validate($request, [
            'id' => 'required|integer|exists:financial_attributes,id',
            'type_id' => 'required|integer|exists:financial_attribute_types,id',
            'value' => 'required|numeric',
            'region_id' => 'required|integer|exists:regions,id',
            'office_id' => 'integer|exists:offices,id',
            'user_id' => 'integer|exists:users,id',
        ]);

        $input = array_filter($request->all(), 'strlen');
        if (isset($input['user_id']) && !isset($input['office_id'])) {
            return response()->json(['Invalid Request'], 422);
        }

        if (isset($input['user_id']) && isset($input['office_id'])) {
            $customFinancialAttribute = CustomFinancialAttribute::where('financial_attribute_id', '=', $input['id'])
                ->where('user_id', '=', $input['user_id'])
                ->where('office_id', '=', $input['office_id'])
                ->where('region_id', '=', $input['region_id'])
                ->first();
        } elseif (isset($input['office_id'])) {
            $customFinancialAttribute = CustomFinancialAttribute::where('financial_attribute_id', '=', $input['id'])
                ->where('office_id', '=', $input['office_id'])
                ->where('region_id', '=', $input['region_id'])
                ->first();
        } else {
            $customFinancialAttribute = CustomFinancialAttribute::where('financial_attribute_id', '=', $input['id'])
                ->where('region_id', '=', $input['region_id'])
                ->first();
        }

        if (!$customFinancialAttribute) {
            $customFinancialAttribute = new CustomFinancialAttribute();
            $customFinancialAttribute->financial_attribute_id = $input['id'];
            $customFinancialAttribute->region_id = isset($input['region_id']) ? $input['region_id'] : null;
            $customFinancialAttribute->office_id = isset($input['office_id']) ? $input['office_id'] : null;
            $customFinancialAttribute->user_id = isset($input['user_id']) ? $input['user_id'] : null;
        }

        $customFinancialAttribute->type_id = $input['type_id'];
        $customFinancialAttribute->value = $input['value'];
        $customFinancialAttribute->save();

        return response()->json(['success'=>true]);
    }

    /**
     * Get agent's financial attributes.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAgentFinancialAttributes(Request $request)
    {
        //abort_if(!Auth::user()->can('manage_mc'), 403);

        $name = $request->get('name');

        $user = User::find($request->get('user_id'));
        $office = Office::find($request->cookie('kw_office'));

        $attributes = CustomFinancialAttribute::forOfficeUser($office, $user, $name)->get();

        return response()->json(['success'=>true, 'attributes' => $attributes]);
    }
}
