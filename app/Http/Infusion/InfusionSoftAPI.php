<?php
namespace App\Http\Infusion;

use App\UserSubmission;
// if(empty(session_id())) session_start();


class InfusionSoftAPI
{

  static function saveUserToInfusionSoft($user)
  {
    require ('src/isdk.php');

    // return var_export($user);
    $app = new \iSDK();
    $app->cfgCon(env('INFUSIONSOFT_CLIENT_ID'), env( 'INFUSIONSOFT_SECRET'));

    $data = $app->addCon(['FirstName'=> $user['name'], 'Email' => $user['email']]);
    // $data = $app->addCon(['FirstName'=> 'test', 'Email' => 'test']);
    return $data;
  }
}
 ?>
