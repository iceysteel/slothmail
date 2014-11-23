<?php
    ini_set('display_errors', 1);
	require 'Yo.php';
    $token = 'd1e535ad-77fc-4bac-ab5d-196ce10ab6f6';
	
	//get user name from user input;
	$user= $_POST["name"];

	//wait time in seconds (replace with email check loop in final code)
	sleep(30);
	
	try {
		$yo = new \che\Yo($token);

		// send a yo to all subscribers
		//$yo->sendAll();
		$yo->sendUser($user);
	} catch (\che\YoException $e) {
		echo "Error #" . $e->getCode() . ": " . $e->getMessage();
	}

?>