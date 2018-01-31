<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;

use KW\Transactions\Models\Office;

class ChangeOfficeController extends Controller
{
    public function change(Request $request)
    {
        if($office_id = $request->get('office_id')) {
            $office = Office::find($office_id);
            if ($office) {
                return redirect()->back()->withCookie(cookie()->forever('kw_office', $office->id));
            }
        }

        return redirect()->back();
    }
}
