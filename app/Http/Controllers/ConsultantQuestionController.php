<?php

namespace App\Http\Controllers;

use App\ConsultantCategory;
use App\ConsultantQuestion;
use Illuminate\Http\Request;

class ConsultantQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ConsultantQuestion::all();
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
        ConsultantQuestion::create($request->all());
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = ConsultantQuestion::where('id', $id)->get();
        return view('consultants.questionnaire.questions.edit', compact("question"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = ConsultantQuestion::find($id);
        return view('consultants.questionnaire.questions.edit', compact("question"));
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
        // dd($request->all());
        $question = ConsultantQuestion::find($id);
        $question->update($request->all());
        $question->save();

        $category =  ConsultantCategory::find($request->category_id);
        $questions = ConsultantQuestion::where('category_id', $request->category_id)->get();

        return view('consultants.questionnaire.edit', compact("category", "questions"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ConsultantQuestion::find($id)->delete();
        return redirect('consultant-questionnaire');
    }
}
