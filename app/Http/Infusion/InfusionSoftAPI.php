<?php
namespace App\Http\Infusion;

use App\UserSubmission;

class InfusionSoftAPI
{

  static function saveUserToInfusionSoft($user)
  {
    require ('src/isdk.php');

    $app = new \iSDK();
    $app->cfgCon(env('INFUSIONSOFT_CLIENT_ID'), env( 'INFUSIONSOFT_SECRET'));

    $infusionsoftID = $app->addCon(['FirstName'=> $user['name'], 'Email' => $user['email']]);
    return $infusionsoftID;
  }
}
 ?>
