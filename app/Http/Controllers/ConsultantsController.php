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
        $answeredQuestionsRequest = collect($request->input('answeredQuestions'))->flatten(1);
        $submission_id = $request->input('submission_id');

        $airtable = new Airtable(array(
          'api_key'=> 'keyXsMhS5ZCyzilpy',
          'base'   => 'appiqLowqq6wqVnb5'
        ));

        $answeredQuestions = DB::table('consultant_submission_metrics')->where(["submission_id" => $submission_id])->get();
        $userSubmission = DB::table('user_submissions')->where(["submission_id" => $submission_id])->first();

        $matches = [];
        $answered = [];
        foreach ($answeredQuestions as $key => $answer) {
            if ($answer->question_name != null) {
                $answered[] = $answer;
            }
        }

        // $params = [
        //   "filterByFormula"=>"AND({record_name} = )"
        // ];

        // $request = $airtable->getContent('Consultants', $params);
        $request = $airtable->getContent('Consultants');
        $airTableConsultants = [];
        do {
            $response = $request->getResponse();
            $airTableConsultants[] = $response[ 'records' ];
        } while ($request = $response->next());

        $airTableConsultantsCollection = collect($airTableConsultants)->flatten(1);

        $airTableConsultants = [];
        foreach ($airTableConsultantsCollection as $airTableConsultantsFields) {
            $airTableConsultants[] = $airTableConsultantsFields;
        }


        foreach ($answered as $key => $answer) {
            foreach ($airTableConsultants as $airTableConsultant) {
                if (isset($answer->question_name)) {
                    if ($answer->question_name == 'vendor') {
                        if ($userSubmission->preferred_vendor == $airTableConsultant->fields->company) {
                            $matches[] = $airTableConsultant;
                        }
                    }
                    if ($answer->question_name == 'industry') {
                        if ($userSubmission->preferred_vendor == $airTableConsultant->fields->company) {
                            $matches[] = $airTableConsultant;
                        }
                    }
                }
            }
        }

        // dd($matches);

        // $consultants =  Consultant::all();
        // $airTableConsultants = AirtableConsultantsTrait::getData();

        $matches = collect($matches);
        //filter $answered shit

        // foreach ($answered as $key => $answer) {
        //     if ($answer['id'] == 8 && $answer['category_id'] == 1) {
        //         if (DB::table('consultants')->where('specialises_in', 'like', $answer['model'])->get()) {
        //             $matches[] = DB::table('consultants')->where('specialises_in', 'like', $answer['model'])->get();
        //         } else {
        //             $matches[] = DB::table('consultants')->whereNotNull('specialises_in')->get();
        //         }
        //     }
        // }
        // $fillers = DB::table('consultants')->where('name', '!=', '')->take(4)->get();
        if ($matches->count() < 5) {
            $moreToFill = 5 - $matches->count();
            $fillers = $airTableConsultantsCollection->random($moreToFill);
            $matches = $matches->merge(collect($fillers));
        }
        $results = $matches->flatten(1);
        $this->emailUserReport($answeredQuestionsRequest);
        // $this->sendThankYouMail($results, $userSubmission);
        $this->sendResultsToUser($results, $userSubmission);
        return $results;
    }

    public function saveSubmissionUserDetails(Request $request)
    {
        \App\UserSubmission::create($request->all());
        return 'success';
    }

    public function saveSubmissionScores(Request $request)
    {
        $answeredQuestions = collect($request->input('scores'))->flatten(1);

        $submission_id = $request->input('submission_id');
        $industry = $request->input('selectedIndustry');
        $vendor =  $request->input('selectedVendor');

        \App\UserSubmission::where("submission_id", $submission_id)->update([
          "industry" =>  $industry,
          "preferred_vendor" =>  isset($vendor) ? $vendor : null,
        ]);

        foreach ($answeredQuestions as $submission) {
            if ($submission != null) {
                $alreadyscored = DB::table('consultant_submission_metrics')->where(["submission_id" => $submission_id, "question_id" => $submission['id']])->get();
                // dd($submission);
                if ($alreadyscored->isEmpty()) {
                    DB::table('consultant_submission_metrics')->insert([
                    "submission_id" => $submission_id,
                    "question_id" => $submission['id'],
                    "model" => $submission['model'],
                    "question_name" => $submission['name'],
                  ]);
                } else {
                    $test = DB::table('consultant_submission_metrics')->where([
                    "submission_id" => $submission_id,
                    "question_id" => $submission['id'],
                  ])->update([
                    "model" => $submission['model'],
                    "question_name" => $submission['name'],
                  ]);
                }
            }
        }
        return "saved";
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
            if (env('APP_ENV') == 'production') {
                $message
            ->from("test@smallbizcrm.com", "SmallBizCRM.com")
            ->to("dnorgarb@gmail.com", "")
            // ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
            ->attach(storage_path('exports/').$name.'.xls')
            ->subject("Report");
            } else {
                $message
            ->from("test@smallbizcrm.com", "SmallBizCRM.com")
            ->to("dnorgarb@gmail.com", "")
            ->to("perry@smallbizcrm.com", "")
            ->attach(storage_path('exports/').$name.'.xls')
            ->subject("Report");
            }
        });
      // Mail::setSwiftMailer($backup);
    }

    public function sendThankYouMail($results = null, $userSubmission = null)
    {
        // dd($userSubmission);
        Mail::send("Email.ThankYouEmailToUserAPI",
       [
          "name" => $userSubmission->name,
          // "crm" => $AirtableData[0]->CRM
       ],
        function ($message) use ($email, $name, $AirtableData) {
            $message
        ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
        ->to($email, $name)
        ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
        });
    }

    public function sendResultsToUser($results = null, $userSubmission = null)
    {
        // dd($userSubmission);
        $userEmail = $userSubmission->email;
        $userName = $userSubmission->name;
        // dd($results);
        Mail::send("Email.EmailConsultantResultsToUserAPI",
       [
          "user" => $userSubmission,
          "results" => $results
       ],
        function ($message) use ($userEmail, $userName, $results) {
            $message
            ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
            ->to($userEmail, $userName)
            ->to("dnorgarb@gmail.com", "")

            // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
            // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
            ->subject("Results from SmallBizCRM.com Consultant Finder");
        });
    }
}
