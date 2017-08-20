<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Carbon\Carbon;
use App\Consultant;
use Illuminate\Http\Request;
use \TANIOS\Airtable\Airtable;
use App\Http\Traits\AirtableConsultantsTrait;

class ConsultantsController extends Controller
{
    use AirtableConsultantsTrait;

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
        $airtable = new Airtable(array(
          'api_key'=> 'keyXsMhS5ZCyzilpy',
          'base'   => 'appiqLowqq6wqVnb5'
        ));


        $matches = [];
        $answered = [];
        foreach ($answeredQuestions as $key => $answer) {
            if ($answer['model'] != false) {
                $answered[] = $answer;
            }
        }
        dd($answered);
        $params = [
          "filterByFormula"=>"AND({record_name} = )"
        ];

        $request = $airtable->getContent('Consultants', $params);
        $airTableConsultants = [];
        do {
            $response = $request->getResponse();
            $airTableConsultants[] = $response[ 'records' ];
        } while ($request = $response->next());

        // dd($airTableConsultants);
        $airTableConsultantsCollection = collect($airTableConsultants)->flatten(1);

        $airTableConsultants = [];
        foreach ($airTableConsultantsCollection as $airTableConsultantsFields) {
            $airTableConsultants[] = $airTableConsultantsFields->fields;
        }


        foreach ($airTableConsultants as $airTableConsultant) {
        }


        // $consultants =  Consultant::all();
        // $airTableConsultants = AirtableConsultantsTrait::getData();

        dd($answeredQuestions);
        return collect($airTableConsultants);
        //filter $answered shit

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
        $this->emailUserReport($answeredQuestions);
        return $results;
    }

    public function saveSubmissionUserDetails(Request $request)
    {
        // dd($request->all());
        \App\UserSubmission::create($request->all());
    }

    public function saveSubmissionScores(Request $request)
    {
        $answeredQuestions = collect($request->input('scores'))->flatten(1);

        $submission_id = $request->input('submissionID');
        $industry = $request->input('selectedIndustry');
        $vendor =  $request->input('selectedVendor');

        \App\UserSubmission::where("submission_id", $submission_id)->update([
          "industry" =>  $industry,
        ]);

        foreach ($answeredQuestions as $submission) {
            if ($submission != null) {
                $alreadyscored = DB::table('consultant_submission_metrics')->where(["submission_id" => $submission_id, "question_id" => $submission['id']])->get();
                if ($alreadyscored->isEmpty()) {
                    DB::table('submissions_metrics')->insert([
                    "submission_id" => $submission_id,
                    "metric_id" => $submission['id'],
                    "created" => time(),
                    "score" => $submission['score'] ?? 0
                  ]);
                } else {
                    // dd($submission);
                    // dd($submission['id']);
                    $test = DB::table('submissions_metrics')->where([
                    "submission_id" => $submission_id,
                    "metric_id" => $submission['id'],
                  ])->update([
                    "score" => $submission['score'] ?? 0
                  ]);
                    // dd($test);
                }
            }
        }

        dd($answeredQuestions);
        dd($request->all());
    }

    public function emailUserReport($questions='')
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
      ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
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
