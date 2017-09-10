<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use Mail;
use Excel;
use Carbon\Carbon;
use App\Consultant;
use App\UserSubmission;
use App\ConsultantReferral;
use App\AirtableConsultant;
use App\UserConsultantResult;
use Illuminate\Http\Request;
use \TANIOS\Airtable\Airtable;
use App\Jobs\SendFollowUpEmail;
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
        $donePreviously =  DB::table('consultant_submission_metrics')->where(["submission_id" => $submission_id])->get();

        $previousResults =  UserConsultantResult::where([
          "submission_id" => $submission_id
          ])->get()->toArray();
          // return collect($previousResults);
          // dd(!empty($previousResults));
        if (!empty($previousResults)) {
            $airTableConsultants = [];
            $request = $airtable->getContent('Consultants');
            // $request = $airtable->getContent('Consultants');
            do {
                $response = $request->getResponse();
                $airTableConsultants[] = $response[ 'records' ];
            } while ($request = $response->next());

            $results = [];
            $airTableConsultantsCollection = collect($airTableConsultants)->flatten(1);
            // dd($airTableConsultantsCollection);
            foreach ($airTableConsultantsCollection as $key => $airtableConsultant) {
                foreach ($previousResults as $previousResult) {
                    // dd($previousResult);
                    if ($airtableConsultant->id == $previousResult['consultant_id']) {
                        $results[] = $airtableConsultant;
                    }
                }
            }
            // dd($results);
            // NOTE: remove below method
            // $userSubmission = DB::table('user_submissions')->where(["submission_id" => $submission_id])->first();
            //
            // $this->sendResultsToUser($results, $userSubmission);

            // $this->emailUserReport($answeredQuestionsRequest);

            return $results;
        }




        $answeredQuestions = DB::table('consultant_submission_metrics')->where(["submission_id" => $submission_id])->get();
        $userSubmission = DB::table('user_submissions')->where(["submission_id" => $submission_id])->first();

        $matches = [];
        $answered = [];
        foreach ($answeredQuestions as $key => $answer) {
            if ($answer->question_name != null) {
                $answered[] = $answer;
            }
        }



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
                        if (isset($airTableConsultant->fields->company)) {
                            if ($userSubmission->preferred_vendor == $airTableConsultant->fields->company) {
                                $matches[] = $airTableConsultant;
                            }
                        }
                    }
                    if ($answer->question_name == 'industry') {
                        if (isset($airTableConsultant->fields->company)) {
                            if ($userSubmission->preferred_vendor == $airTableConsultant->fields->company) {
                                $matches[] = $airTableConsultant;
                            }
                        }
                    }
                }
            }
        }


        $matches = collect($matches);
        //filter $answered shit
        if ($matches->count() < 5) {
            $moreToFill = 5 - $matches->count();
            $fillers = $airTableConsultantsCollection->random($moreToFill);
            $matches = $matches->merge(collect($fillers));
        }
        $results = $matches->flatten(1);

        $updatedUserID = UserSubmission::where("submission_id", $submission_id)->first();
        $user_id = $updatedUserID->id;

        foreach ($results as $key => $result) {
            // dd($result);
            UserConsultantResult::create(
              [
                "submission_id" => $submission_id,
                "user_id" => $user_id,
                "consultant" => $result->fields->record_name,
                "consultant_id" => $result->id,
              ]
            );
        }

        $this->emailUserReport($answeredQuestionsRequest);
        $this->sendResultsToUser($results, $userSubmission);

        return $results;
    }

    public function saveSubmissionUserDetails(Request $request)
    {
        UserSubmission::create($request->all());
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
        return ["saved" => true ];
    }

    public function emailUserReport($questions='')
    {
        $results = $questions;
        $time = date('H:i:s');
        $name = 'SBCRM'.$time;

        $categories =  \App\ConsultantCategory::all();

        $pdf = Excel::create($name, function ($excel) use (&$results) {
            $excel->setTitle('Our new awesome title');
            $excel->setCreator('Maatwebsite')
              ->setCompany('Maatwebsite');

        // Call them separately
        $excel->setDescription('A demonstration to change the file properties');
            $excel->sheet('Excel sheet', function ($sheet) use (&$results) {
                $sheet->fromArray($results);
            });
        })->store('xls');

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);

        $beautymail->send('Email.EmailConsultantReportAPI', ['questions' => $questions, 'categories' =>  $categories],
         function ($message) use ($name) {
             if (env('APP_ENV') == 'production') {
                 $message
          ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "")
          // ->to("perry@smallbizcrm.com", "No email record in DB for this referral")
          ->to("perry@smallbizcrm.com", "")
          ->attach(storage_path('exports/').$name.'.xls')
          ->subject("CRM Consulting Enquiry");
             } else {
                 $message
          ->from("test@smallbizcrm.com", "SmallBizCRM.com")
          ->to("dnorgarb@gmail.com", "")
          ->attach(storage_path('exports/').$name.'.xls')
          ->subject("CRM Consulting Enquiry");
             }
         });
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
        // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
        ->subject("Thank You " . $name ."," . " " . $AirtableData[0]->CRM . " ". "Will be in contact with you shortly ");
        });
    }

    public function sendResultsToUser($results = null, $userSubmission = null)
    {
        $userEmail = $userSubmission->email;
        $userName = $userSubmission->name;
        Mail::send("Email.EmailConsultantResultsToUserAPI",
       [
          "user" => $userSubmission,
          "results" => $results
       ],
        function ($message) use ($userEmail, $userName, $results) {
            $message
            ->from("perry@smallbizcrm.com", "SmallBizCRM.com")
            ->to($userEmail, $userName)
            ->to("devin@smallbizcrm.com", "SmallBizCRM.com")
            // ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
            ->to("perry@smallbizcrm.com", "SmallBizCRM.com") // NOTE: Jono, requires 2 Parameters
            ->subject("Results from SmallBizCRM.com Consultant Finder");
        });
        $userData = [
          "email" => $userEmail,
          "name" => $userName,
        ];
        // dispatch(new SendFollowUpEmail($userData));
        $job = (new SendFollowUpEmail($userData))->delay(\Carbon\Carbon::now('Africa/Cairo')->addMinutes(2));
        dispatch($job);
    }

    public function vendorReferral(Request $request)
    {
        $user_info = $request->all();
        // dd($user_info);
        ConsultantReferral::create($user_info);
    }

    public function compareConsultants(Request $request)
    {
        $consultantsToCompare = collect($request->all())->flatten(1);

        $consultantsResults = [];
        $consultantsResultIds = [];
        foreach ($consultantsToCompare as $key => $consultant) {
            $consultantsResults[] = AirtableConsultant::where(['airtable_id' => $consultant['result']['id']])->first();
            $res = AirtableConsultant::where(['airtable_id' => $consultant['result']['id']])->first();
            $consultantsResultIds[] = $res->id;
        }
        $consultantsResults = collect($consultantsResults);
        $results = $consultantsResults->unique();
        $resultsCollection = $results->values()->all();

        $airtableConsultants = AirtableConsultantsTrait::getData();

        $matches = [];
        foreach (collect($airtableConsultants)->flatten(1) as $key => $airtableConsultant) {
            foreach ($resultsCollection as $key => $resultCollection) {
                $dbConsultant = $resultCollection->toArray();
                if ($airtableConsultant->id == $dbConsultant['airtable_id']) {
                    $matches[] = $airtableConsultant;
                }
            }
        }
        return $matches;
    }

    public function getConsultantInfo($id='')
    {
        $airtableConsultants = AirtableConsultantsTrait::getData();

        $matches = [];
        foreach (collect($airtableConsultants)->flatten(1) as $key => $airtableConsultant) {
            if ($airtableConsultant->id == $id) {
                $matches[] = $airtableConsultant;
            }
        }
        return $matches;
    }
}
