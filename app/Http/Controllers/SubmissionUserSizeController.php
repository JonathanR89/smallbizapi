<?php

namespace App\Http\Controllers;

use App\SubmissionUserSize;
use Illuminate\Http\Request;

class SubmissionUserSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userSizes = SubmissionUserSize::all();

        return view('forms.user-sizes', compact("userSizes"));
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
         SubmissionUserSize::create($request->all());
         return redirect('submission-user-sizes');
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
         $userSize = SubmissionUserSize::find($id);
         return view('forms.user-sizes-edit', compact("userSize"));
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
         $cat = SubmissionUserSize::find($id);
         $cat->update($request->all());
         $cat->save();
         return redirect('submission-user-sizes');
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     {
         SubmissionUserSize::find($id)->delete();
         return redirect('submission-user-sizes');
     }
}
