<?php
namespace App\Http\Traits;

if(empty(session_id())) session_start();
use  \Infusionsoft;

trait InfusionSoftAPITrait
{
  static function saveUserToInfusionSoft($id)
  {
    $infusionsoft = new \Infusionsoft\Infusionsoft(array(
	'clientId'     =>  env('INFUSIONSOFT_CLIENT_ID'),
	'clientSecret' => env( 'INFUSIONSOFT_SECRET'),
	'redirectUri'  =>  env('INFUSIONSOFT_REDIRECT_URL'),
));

   // return $test;

// if (isset($_SESSION['token'])) {
//   echo $infusionsoft->setToken(unserialize($_SESSION['token']));
// }
// return $infusionsoft->getToken();
// If we are returning from Infusionsoft we need to exchange the code for an
// access token.
// $_SESSION['token'] = serialize($infusionsoft->getToken());
$tasks = $infusionsoft->tasks()->all();

// $_SESSION['token'] =
// $_SESSION['token'] = serialize($infusionsoft->requestAccessToken($_GET['code']));
// if (isset($_GET['code']) and !$infusionsoft->getToken()) {
// }

// if ($infusionsoft->getToken()) {
// 	// Save the serialized token to the current session for subsequent requests
// } else {
//   echo $infusionsoft->getAuthorizationUrl();
// }

// echo unserialize($_SESSION['token']);
    //
    // $data = Infusionsoft::data()->query("Contact",1000,0, ['Id' => '123'],['Id','FirstName','LastName','Email'], 'Id', false);
    // dd($data);
  }
}
 ?>
