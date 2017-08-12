<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Carbon\Carbon;
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
            }
        }
        $fillers = DB::table('consultants')->where('name', '!=', '')->take(4)->get();
        $results = collect($matches);
        $results = $results->merge($fillers);
        $results = $results->flatten(1);
        $this->emailUserEport($answeredQuestions);
        return $results;
    }

    public function emailUserEport($questions='')
    {
        $results = $questions;
        $time = date('H:i:s');
        $name = 'SBCRM'.$time;

        $pdf =  Excel::create($name, function ($excel) use (&$results) {
            $excel->setTitle('Our new awesome title');
            $excel->setCreator('Maatwebsite')
              ->setCompany('Maatwebsite');

        // Call them separately
        $excel->setDescription('A demonstration to change the file properties');
            $excel->sheet('Excel sheet', function ($sheet) use (&$results) {
                $sheet->fromArray($results);
            });
        })->store('xls');


        Mail::send("Email.EmailConsultantReportAPI", ['data' => $questions],
      function ($message) use ($name) {
          $message
      ->from("test@smallbizcrm.com", "SmallBizCRM.com")
      ->to("dnorgarb@gmail.com", "No email record in DB for this referral")
      ->attach(storage_path('exports/').$name.'.xls')
      ->subject("Report");
      });
      // Mail::setSwiftMailer($backup);
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
