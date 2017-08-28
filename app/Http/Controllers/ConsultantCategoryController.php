<?php

namespace App\Http\Controllers;

use App\ConsultantQuestion;
use App\ConsultantCategory;
use Illuminate\Http\Request;

class ConsultantCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories =  ConsultantCategory::all();
        return view('consultants.questionnaire.index', compact("categories"));
    }

    public function getCategories()
    {
        $categories = ConsultantCategory::paginate(1);
        return $categories;
    }

    public function getCategoryQuestions(Request $request)
    {
        $category = $request->all();
        $metrics = ConsultantQuestion::where('category_id', $category['category'])->get();

        return $metrics;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('consultants.questionnaire.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ConsultantCategory::create($request->all());
        return redirect('consultant-questionnaire');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $questions = ConsultantQuestion::where('category_id', $id)->get();
        $category =  ConsultantCategory::find($id);
        return view('consultants.questionnaire.show', compact("category", "questions"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category =  ConsultantCategory::find($id);
        return view('consultants.questionnaire.edit', compact("category"));
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
        $cat = ConsultantCategory::find($id);
        $cat->update($request->all());
        $cat->save();
        return redirect('consultant-questionnaire');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = ConsultantCategory::where('id', $id)->delete();
        return redirect('consultant-questionnaire');
    }
}
