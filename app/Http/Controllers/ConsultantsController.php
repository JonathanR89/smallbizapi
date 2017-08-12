<?php

namespace App\Http\Controllers;

use DB;
use App\Consultant;
use Illuminate\Http\Request;

class ConsultantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $consultants =  Consultant::all();
        return view('consultants.index', compact("consultants"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('consultants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Consultant::create($request->all());
        return redirect('consultants');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response blueCamroo
     */
    public function show($id)
    {
        $consultant =  Consultant::find($id);
        return view('consultants.show', compact("consultant"));
    }


    public function getQustionnaireResults(Request $request)
    {
        $answeredQuestions = collect($request->all())->flatten(2);
        $consultants =  Consultant::all();

        //filter $answered shit
        $matches = [];
        $answered = [];
        foreach ($answeredQuestions as $key => $answer) {
            if ($answer['model'] != false) {
                $answered[] = $answer;
            }
        }

        foreach ($answered as $key => $answer) {
            if ($answer['id'] == 8 && $answer['category_id'] == 1) {
                if (DB::table('consultants')->where('specialises_in', 'like', $answer['model'])->get()) {
                    $matches[] = DB::table('consultants')->where('specialises_in', 'like', $answer['model'])->get();
                } else {
                    $matches[] = DB::table('consultants')->whereNotNull('specialises_in')->get();
                }
            } else {
                $matches[] =  DB::table('consultants')->take(5)->get();
            }
        }

        return collect($matches)->flatten(1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
