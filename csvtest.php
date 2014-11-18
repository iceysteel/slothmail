<?php

/*$csvData = file_get_contents('data.csv');
$lines = explode(PHP_EOL, $csvData);
$array = array();
foreach ($lines as $line) {
    $array[] = str_getcsv($line);
}*/

function crunchEmail($email)
{
	require_once('smtp_validateEmail.class.php');

	// the email to validate
	//$email = 'zainm211@bullshit.com';
	// an optional sender
	$sender = 'root@clevrly.me';
	// instantiate the class
	$SMTP_Validator = new SMTP_validateEmail();
	// turn on debugging if you want to view the SMTP transaction
	//$SMTP_Validator->debug = true;
	// do the validation
	$results = $SMTP_Validator->validate(array($email), $sender);
	// view results
	//echo $email.' is '.($results[$email] ? 'valid' : 'invalid')."\n <br>";
	return ($results[$email] ? TRUE : FALSE);

}

function testemail($email){
	return FALSE;
}

function displayCount($count){
	echo 'currently on email#'.$counter.'<br>';
}

$csv = array_map('str_getcsv', file('Bounced.csv'));

/* foreach($csv as &$value){
	crunchemail($value[1]);
	
	echo $value[1]." " ;
	echo $value[2]."\n <br>" ;
} */

//crunchemail('zainm211@bullshit');

//echo 'your file is being processed.<br>';
//echo 'crunching emails can take some time, 10 mins or more is normal. feel free to go do something and come back!<br>';

// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=ValidEmails.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');
//make email counter variable
$counter = 0;

//loop through the csv and add the valid emails to the new csv 
foreach($csv as &$value){
	$counter++;
	//displayCount($counter);
	if(crunchEmail($value[1])==TRUE){
		fputcsv($output, $value);
	}
} 

//echo "Finished! A .csv file with all the valid emails should download now. Happy emailing <br>"
//fputcsv($csv, $output);


?>