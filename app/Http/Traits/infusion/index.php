<?php require_once('src/isdk.php');

$app = new iSDK();

$app->cfgCon('pb301','274cacee1b19c69af235492a165fa913');

//$contacts = $app->findByEmail('devro@gmail.com', array('Id','FirstName','LastName','Email'));

//print_r ($contacts);
?>










    <div class="row">
        <div class="col-md-8">
            <form class="well" action="index.php" method="post">
               
              

                <p>Firstname</p>
                <div class="form-group">
                    <input type="text" name="FirstName" class="form-control" />
                </div>
                <p>LastName</p>
                <div class="form-group">
                    <input type = 'text' name="LastName" class="form-control" />
                </div>
                <p>Email</p>
                <div class="form-group">
                    <input type="email" name="Email" class="form-control"  />
                </div>
                
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
         
        </div>
    </div>
    
   
  <?php 


    
    
// $FirstName = 'devs' ;//$_POST['FirstName'];  
////  $LastName = $_POST['LastName'];  
////  $Email = $_POST['Email']; 
//    
//    
//
//$contactData = array('FirstName' => $FirstName );
////                     'LastName'  => '{$LastName}' ,
////                     'Email'     =>  '{$Email}');
//
//$conID = $app->addCon($contactData);
//



if(isset($_POST['submit'])){

$fname = $_POST['FirstName'];
$lname = $_POST['LastName'];
$email = $_POST['Email'];



// Update contact record using AddWithDupCheck method
$data = array('FirstName' => $fname, // The key on the left must exact match table field names
'LastName' => $lname, // The value on the right can be anything as long as type matches field
'Email' => $email); // e.g you cannot put a string in date field
$update = $app->addWithDupCheck($data, 'Email'); // This is the API call which checks for duplicates using Email and Name



echo $update; // If successful, this will return the contactId of the contact added or updated



                }




?>


<?php








$countries = [
    'South Africa',
    'Afghanistan',
    'Åland Islands',
    'Albania',
    'Algeria',
    'American Samoa',
    'Andorra',
    'Angola',
    'Anguilla',
    'Antarctica',
    'Antigua and Barbuda',
    'Argentina',
    'Armenia',
    'Aruba',
    'Australia',
    'Austria',
    'Azerbaijan',
    'Bahamas',
    'Bahrain',
    'Bangladesh',
    'Barbados',
    'Belarus',
    'Belgium',
    'Belize',
    'Benin',
    'Bermuda',
    'Bhutan',
    'Bolivia, Plurinational State of',
    'Bonaire, Sint Eustatius and Saba',
    'Bosnia and Herzegovina',
    'Botswana',
    'Bouvet Island',
    'Brazil',
    'British Indian Ocean Territory',
    'Brunei Darussalam',
    'Bulgaria',
    'Burkina Faso',
    'Burundi',
    'Cambodia',
    'Cameroon',
    'Canada',
    'Cape Verde',
    'Cayman Islands',
    'Central African Republic',
    'Chad',
    'Chile',
    'China',
    'Christmas Island',
    'Cocos (Keeling) Islands',
    'Colombia',
    'Comoros',
    'Congo',
    'Congo, the Democratic Republic of the',
    'Cook Islands',
    'Costa Rica',
    'Côte d\'Ivoire',
    'Croatia',
    'Cuba',
    'Curaçao',
    'Cyprus',
    'Czech Republic',
    'Denmark',
    'Djibouti',
    'Dominica',
    'Dominican Republic',
    'Ecuador',
    'Egypt',
    'El Salvador',
    'Equatorial Guinea',
    'Eritrea',
    'Estonia',
    'Ethiopia',
    'Falkland Islands (Malvinas)',
    'Faroe Islands',
    'Fiji',
    'Finland',
    'France',
    'French Guiana',
    'French Polynesia',
    'French Southern Territories',
    'Gabon',
    'Gambia',
    'Georgia',
    'Germany',
    'Ghana',
    'Gibraltar',
    'Greece',
    'Greenland',
    'Grenada',
    'Guadeloupe',
    'Guam',
    'Guatemala',
    'Guernsey',
    'Guinea',
    'Guinea-Bissau',
    'Guyana',
    'Haiti',
    'Heard Island and McDonald Mcdonald Islands',
    'Holy See (Vatican City State)',
    'Honduras',
    'Hong Kong',
    'Hungary',
    'Iceland',
    'India',
    'Indonesia',
    'Iran, Islamic Republic of',
    'Iraq',
    'Ireland',
    'Isle of Man',
    'Israel',
    'Italy',
    'Jamaica',
    'Japan',
    'Jersey',
    'Jordan',
    'Kazakhstan',
    'Kenya',
    'Kiribati',
    'Korea, Democratic People\'s Republic of',
    'Korea, Republic of',
    'Kuwait',
    'Kyrgyzstan',
    'Lao People\'s Democratic Republic',
    'Latvia',
    'Lebanon',
    'Lesotho',
    'Liberia',
    'Libya',
    'Liechtenstein',
    'Lithuania',
    'Luxembourg',
    'Macao',
    'Macedonia, the Former Yugoslav Republic of',
    'Madagascar',
    'Malawi',
    'Malaysia',
    'Maldives',
    'Mali',
    'Malta',
    'Marshall Islands',
    'Martinique',
    'Mauritania',
    'Mauritius',
    'Mayotte',
    'Mexico',
    'Micronesia, Federated States of',
    'Moldova, Republic of',
    'Monaco',
    'Mongolia',
    'Montenegro',
    'Montserrat',
    'Morocco',
    'Mozambique',
    'Myanmar',
    'Namibia',
    'Nauru',
    'Nepal',
    'Netherlands',
    'New Caledonia',
    'New Zealand',
    'Nicaragua',
    'Niger',
    'Nigeria',
    'Niue',
    'Norfolk Island',
    'Northern Mariana Islands',
    'Norway',
    'Oman',
    'Pakistan',
    'Palau',
    'Palestine, State of',
    'Panama',
    'Papua New Guinea',
    'Paraguay',
    'Peru',
    'Philippines',
    'Pitcairn',
    'Poland',
    'Portugal',
    'Puerto Rico',
    'Qatar',
    'Réunion',
    'Romania',
    'Russian Federation',
    'Rwanda',
    'Saint Barthélemy',
    'Saint Helena, Ascension and Tristan da Cunha',
    'Saint Kitts and Nevis',
    'Saint Lucia',
    'Saint Martin (French part)',
    'Saint Pierre and Miquelon',
    'Saint Vincent and the Grenadines',
    'Samoa',
    'San Marino',
    'Sao Tome and Principe',
    'Saudi Arabia',
    'Senegal',
    'Serbia',
    'Seychelles',
    'Sierra Leone',
    'Singapore',
    'Sint Maarten (Dutch part)',
    'Slovakia',
    'Slovenia',
    'Solomon Islands',
    'Somalia',
    'South Georgia and the South Sandwich Islands',
    'South Sudan',
    'Spain',
    'Sri Lanka',
    'Sudan',
    'Suriname',
    'Svalbard and Jan Mayen',
    'Swaziland',
    'Sweden',
    'Switzerland',
    'Syrian Arab Republic',
    'Taiwan, Province of China',
    'Tajikistan',
    'Tanzania, United Republic of',
    'Thailand',
    'Timor-Leste',
    'Togo',
    'Tokelau',
    'Tonga',
    'Trinidad and Tobago',
    'Tunisia',
    'Turkey',
    'Turkmenistan',
    'Turks and Caicos Islands',
    'Tuvalu',
    'Uganda',
    'Ukraine',
    'United Arab Emirates',
    'United Kingdom',
    'United States',
    'United States Minor Outlying Islands',
    'Uruguay',
    'Uzbekistan',
    'Vanuatu',
    'Venezuela, Bolivarian Republic of',
    'Viet Nam',
    'Virgin Islands, British',
    'Virgin Islands, U.S.',
    'Wallis and Futuna',
    'Western Sahara',
    'Yemen',
    'Zambia',
    'Zimbabwe',
];
?>
 
 
 
 <!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Results - SmallBizCRM Finder - Your Quick Guide To Choosing a CRM</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="crm.css" />
    </head>
    <body>
        <div class="container">
            <a href="http://www.smallbizcrm.com/" class="main-logo"><img src="logo.png" /></a>
            <h1>SmallBizCRM Finder <small>Your Quick Guide To Choosing a CRM</small></h1>
            <div class="pad-text">
                <p>To get your personalized report just enter your name and work email address and the other fields below.</p>
                <p>Based on what you've said is important to you, and other factors you've entered above, we’ll send you a short report to help you focus your valuable time on those areas that will increase your likelihood of selecting a CRM system that will be a good fit for your business and your needs.</p>
            </div>
            <form action="results.php" method="post" style="width: 50%;">
               
               
               
                <input type="hidden" name="key" value="<?= htmlspecialchars($key, ENT_QUOTES, 'utf-8') ?>" />
                
                
                
                <div class="form-group<?php if (isset($errors['first_name'])) { ?> has-error<?php } ?>">
                    <input type="text" name="first_name" id="first_name" placeholder="First name..." value="<?= isset($values['first_name']) ? htmlspecialchars($values['first_name'], ENT_QUOTES, 'utf-8') : '' ?>" class="form-control" />
                    <?php if (isset($errors['first_name'])) { ?><p class="help-block"><?= htmlspecialchars($errors['first_name'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                
                <div class="form-group<?php if (isset($errors['last_name'])) { ?> has-error<?php } ?>">
                    <input type="text" name="last_name" id="last_name" placeholder="Last name..." value="<?= isset($values['last_name']) ? htmlspecialchars($values['last_name'], ENT_QUOTES, 'utf-8') : '' ?>" class="form-control" />
                    <?php if (isset($errors['last_name'])) { ?><p class="help-block"><?= htmlspecialchars($errors['last_name'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                
                
                <div class="form-group<?php if (isset($errors['email'])) { ?> has-error<?php } ?>">
                    <input type="text" name="email" id="email" placeholder="Business email address..." value="<?= isset($values['email']) ? htmlspecialchars($values['email'], ENT_QUOTES, 'utf-8') : '' ?>" class="form-control" />
                    <?php if (isset($errors['email'])) { ?><p class="help-block"><?= htmlspecialchars($errors['email'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                <div class="form-group<?php if (isset($errors['website'])) { ?> has-error<?php } ?>">
                    <input type="text" name="website" id="website" placeholder="Company website..." value="<?= isset($values['website']) ? htmlspecialchars($values['website'], ENT_QUOTES, 'utf-8') : '' ?>" class="form-control" />
                    <?php if (isset($errors['website'])) { ?><p class="help-block"><?= htmlspecialchars($errors['website'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                
                <div class="form-group<?php if (isset($errors['industry'])) { ?> has-error<?php } ?>">
                    <input type="text" name="industry" id="industry" placeholder="Industry..." value="<?= isset($values['industry']) ? htmlspecialchars($values['industry'], ENT_QUOTES, 'utf-8') : '' ?>" class="form-control" />
                    <?php if (isset($errors['industry'])) { ?><p class="help-block"><?= htmlspecialchars($errors['industry'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                
                <div class="form-group<?php if (isset($errors['country'])) { ?> has-error<?php } ?>">
                    <select name="country" id="country" class="form-control">
                        <option value="">Country...</option>
                        <option value="">--</option>
                        <?php foreach ($countries as $country) { ?>
                           
                            <option value="<?= htmlspecialchars($country, ENT_QUOTES, 'utf-8') ?>"<?php if (isset($values['country']) && $country == $values['country']) { ?> selected="selected"<?php } ?>><?= htmlspecialchars($country, ENT_QUOTES, 'utf-8') ?></option>
                            
                        <?php } ?>
                    </select>
                    
                    <?php if (isset($errors['country'])) { ?><p class="help-block"><?= htmlspecialchars($errors['country'], ENT_QUOTES, 'utf-8') ?></p><?php } ?>
                </div>
                
                
                
                <button type="submit" class="btn btn-primary">Next</button>
            </form>
            <p class="footer">&copy;SmallBizCRM.com, 2015.  In association with Mark Stonham of Wurlwind.co.uk.</p>
        </div>
























