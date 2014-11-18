<?php

/**
 * Example 2
 * Validate a single Email via SMTP
 */

// include SMTP Email Validation Class
require_once('smtp_validateEmail.class.php');

// the email to validate
$emails = array('zainm211@hotmail.com', 'potatomuffin.zse@gmail.com', 'test@baloney.com');
// an optional sender
$sender = 'root@clevrly.me';
// instantiate the class
$SMTP_Validator = new SMTP_validateEmail();
// turn on debugging if you want to view the SMTP transaction
$SMTP_Validator->debug = true;
// do the validation
$results = $SMTP_Validator->validate($emails, $sender);

// view results
foreach($results as $email=>$result) {
	// send email? 
  if ($result) {
    //mail($email, 'Confirm Email', 'Please reply to this email to confirm', 'From:'.$sender."\r\n"); // send email
  } else {
    echo 'The email address '. $email.' is not valid';
  }
}
?>