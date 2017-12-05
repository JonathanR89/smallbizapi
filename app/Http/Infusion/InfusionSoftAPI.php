<?php
namespace App\Http\Infusion;

use App\UserSubmission;
use Illuminate\Http\Request;

class InfusionSoftAPI
{

    static $api;

    public static function saveUserToInfusionSoft($user)
    {
        $infusionsoftID = self::infusionAPI()->addCon([
            'FirstName' => $user['name'], 'Email' => $user['email'],
        ]);
        // var_export($infusionsoftID);
        return $infusionsoftID;
    }

    public static function saveUserAnswers($resultsKey, Request $request)
    {

        $infusionsoft_user = UserSubmission::where([
            "submission_id" => $request->submissionID,
            "id" => $request->user_id,
        ])->get();

        $data = [
            'Email' => $infusionsoft_user[0]->email ?? "No Email Provided",
            'Website' => "Field not included in current form",
            '_PriceRange0' => $request->selectedPriceRange,
            '_Industry0' => $request->selectedIndustry,
            '_IndustryOther' => "Field not included in current form",
            '_Comments' => $request->additionalComments,
            '_Results' => 'http://finder.smallbizcrm.com/#/results?submissionID=' . $request->submissionID,
            '_QQ2' => 'QQ2',
        ]; /*  */

        //call that sends data to infusionsoft database
        $Integration = 'smallbizcrm';
        $callName = 'QQ2';
        // dd(Self::$api);
        // var_export($request);
        $caller = self::infusionAPI();
        if (isset($infusionsoft_user[0]->infusionsoft_user_id)) {
            $cid = $caller->updateCon($infusionsoft_user[0]->infusionsoft_user_id, $data);
            $caller->achieveGoal($Integration, $callName, $cid);
        }
    }

    public static function infusionAPI()
    {
        require 'src/isdk.php';

        self::$api = new \iSDK();
        self::$api->cfgCon(env('INFUSIONSOFT_CLIENT_ID'), env('INFUSIONSOFT_SECRET'));

        return self::$api;
    }

}
