<?php

namespace KW\Transactions\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use KW\Transactions\Models\Currency;
use KW\Transactions\Models\Language;
use KW\Transactions\Models\Locale;
use KW\Transactions\Models\Region;


class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(!Auth::user()->can('manage_region'), 403);

        $regions = Region::where('parent_id', '!=', null)->orderBy('name', 'asc')->with(['language','locale','currency'])
            ->get();

        return view('region.index', [
            'regions' => $regions,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!Auth::user()->can('manage_region'), 403);

        return view('region.create', [
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
        abort_if(!Auth::user()->can('manage_region'), 403);

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:regions,name',
            'default_language' => 'required|integer|exists:languages,id',
            'default_locale' => 'required|integer|exists:locales,id',
            'default_currency' => 'required|integer|exists:currencies,id'
        ]);

        $region = new Region();
        $region->name = $request->get('name');

        $language_id = $request->get('default_language');
        $language = Language::find($language_id);
        $region->language()->associate($language);

        $locale_id = $request->get('default_locale');
        $locale = Locale::find($locale_id);
        $region->locale()->associate($locale);

        $currency_id = $request->get('default_currency');
        $currency = Currency::find($currency_id);
        $region->currency()->associate($currency);

        $region->save();

        return redirect()->route('region.edit', ['id' => $region->id])->with('status', trans('region.region_created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        abort_if(!Auth::user()->can('manage_region'), 403);

        return view('region.edit', [
            'region' => $region,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        abort_if(!Auth::user()->can('manage_region'), 403);

        $this->validate($request, [
            'name' => 'required|string|max:255|unique:regions,name,'.$region->name,
            'default_language' => 'required|integer|exists:languages,id',
            'default_locale' => 'required|integer|exists:locales,id',
            'default_currency' => 'required|integer|exists:currencies,id'
        ]);

        $region->name = $request->get('name');

        $language_id = $request->get('default_language');
        $language = Language::find($language_id);
        $region->language()->associate($language);

        $locale_id = $request->get('default_locale');
        $locale = Locale::find($locale_id);
        $region->locale()->associate($locale);

        $currency_id = $request->get('default_currency');
        $currency = Currency::find($currency_id);
        $region->currency()->associate($currency);

        $region->save();

        return redirect()->route('region.edit', ['id' => $region->id])->with('status', trans('region.region_updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        //
    }
}
