<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KW\Transactions\Models\Currency;
use KW\Transactions\Models\CustomFinancialAttribute;
use KW\Transactions\Models\FinancialAttributeType;
use KW\Transactions\Models\Language;
use KW\Transactions\Models\Locale;
use KW\Transactions\Models\Region;
use KW\Transactions\Models\Office;


class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        $offices = Office::orderBy('name', 'asc')->with(['language','locale','currency','region'])
            ->get();

        return view('office.index', [
            'offices' => $offices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        return view('office.create', [
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:offices,name',
            'region_id' => 'required|integer|exists:regions,id',
            'default_language' => 'required|integer|exists:languages,id',
            'default_locale' => 'required|integer|exists:locales,id',
            'default_currency' => 'required|integer|exists:currencies,id'
        ]);

        $office = new Office();
        $office->name = $request->get('name');

        $region_id = $request->get('region_id');
        $region = Region::find($region_id);
        $office->region()->associate($region);

        $language_id = $request->get('default_language');
        $language = Language::find($language_id);
        $office->language()->associate($language);

        $locale_id = $request->get('default_locale');
        $locale = Locale::find($locale_id);
        $office->locale()->associate($locale);

        $currency_id = $request->get('default_currency');
        $currency = Currency::find($currency_id);
        $office->currency()->associate($currency);

        $office->save();

        return redirect()->route('office.edit', ['id' => $office->id])->with('status', trans('office.office_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Office  $office
     * @return \Illuminate\Http\Response
     */
    public function show(Office $office)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Office  $office
     * @return \Illuminate\Http\Response
     */
    public function edit(Office $office)
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        return view('office.edit', [
            'office' => $office,
            'officeFinancialAttributes' => CustomFinancialAttribute::forOffice($office)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Office  $office
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Office $office)
    {
        abort_if(!Auth::user()->can('manage_mc'), 403);

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:offices,name,'.$office->name,
            'region_id' => 'required|integer|exists:regions,id',
            'default_language' => 'required|integer|exists:languages,id',
            'default_locale' => 'required|integer|exists:locales,id',
            'default_currency' => 'required|integer|exists:currencies,id'
        ]);

        $office->name = $request->get('name');

        $region_id = $request->get('region_id');
        $region = Region::find($region_id);
        $office->region()->associate($region);

        $language_id = $request->get('default_language');
        $language = Language::find($language_id);
        $office->language()->associate($language);

        $locale_id = $request->get('default_locale');
        $locale = Locale::find($locale_id);
        $office->locale()->associate($locale);

        $currency_id = $request->get('default_currency');
        $currency = Currency::find($currency_id);
        $office->currency()->associate($currency);

        $office->save();

        return redirect()->route('office.edit', ['id' => $office->id])->with('status', trans('office.office_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Office  $office
     * @return \Illuminate\Http\Response
     */
    public function destroy(Office $office)
    {
        //
    }
}
