<?php

namespace App\Http\Controllers;

use App\SubmissionPriceRange;
use Illuminate\Http\Request;

class SubmissionPriceRangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $priceRanges = SubmissionPriceRange::all();

        return view('forms.price-ranges', compact("priceRanges"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SubmissionPriceRange::create($request->all());
        return redirect('submission-price-ranges');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $priceRange = SubmissionPriceRange::find($id);
        return view('forms.price-ranges-edit', compact("priceRange"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cat = SubmissionPriceRange::find($id);
        $cat->update($request->all());
        $cat->save();
        return redirect('submission-price-ranges');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SubmissionPriceRange::find($id)->delete();
        return redirect('submission-price-ranges');
    }
}
