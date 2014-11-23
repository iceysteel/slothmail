<?php


//get file code 


$target_dir = "test/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	$uploadOk = 1;
}

// Allow certain file formats
/* if($imageFileType != "csv") {
    echo "Sorry, only csv files are allowed.";
    $uploadOk = 0;
} */
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
}


//start code for crunching emails

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
	return TRUE;
}

function displayCount($count){
	  //echo 'currently on email#'.$count.'<br>';
}

$csv = array_map('str_getcsv', file($_FILES["fileToUpload"]["tmp_name"]));

/* foreach($csv as &$value){
	crunchemail($value[1]);
	
	echo $value[1]." " ;
	echo $value[2]."\n <br>" ;
} */

//crunchemail('zainm211@bullshit');

//echo 'your file is being processed.<br>';
//echo 'crunching emails can take some time, 10 mins or more is normal. feel free to go do something and come back!<br>';

// output headers so that the file is downloaded rather than displayed
//header('Content-Type: text/csv; charset=utf-8');
//header('Content-Disposition: attachment; filename=ValidEmails.csv');
function create_csv_string($csvdata) {

	// create a file pointer connected to the output stream
	if (!$output = fopen('php://temp', 'w+')) return FALSE;
	//$name = tempnam('/', 'csv');
	//$output = fopen($name, 'w');
	//$output = tmpfile();
	//make email counter variable
	$counter = 0;

	//loop through the csv and add the valid emails to the new csv 
	foreach($csvdata as &$value){
		$counter++;
		displayCount($counter);
		if(crunchEmail($value[1])==TRUE){
			fputcsv($output, $value);
		}
	} 
	//echo "Finished! A .csv file with all the valid emails should download now. Happy emailing <br>"
	//fputcsv($csv, $output);
	// Place stream pointer at beginning
	rewind($output);

	// Return the data
	return stream_get_contents($output);
}
include 'attachment.php';

?>