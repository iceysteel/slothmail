<?php

 //If there is no error, send the email

$EmailTo = $_POST["email"];
$EmailFrom = "honeybadger@listbadger.com";
$EmailSubject = "Your processed .csv";
$message = "Hey we crunched your email list! We've attached it below so enjoy! :)";

//save the user's email into our SQL database
include 'sqltest.php';


function send_csv_mail ($csvdata , $body, $to = 'youraddress@example.com', $subject = 'Test email with attachment', $from = 'webmaster@example.com') {

  // This will provide plenty adequate entropy
  $multipartSep = '-----'.md5(time()).'-----';

  // Arrays are much more readable
  $headers = array(
    "From: $from",
    "Reply-To: $from",
    "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
  );

  // Make the attachment
  $attachment = chunk_split(base64_encode(create_csv_string($csvdata))); 

  // Make the body of the message
  $body = "--$multipartSep\r\n"
        . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n"
        . "\r\n"
        . "$body\r\n"
        . "--$multipartSep\r\n"
        . "Content-Type: text/csv\r\n"
        . "Content-Transfer-Encoding: base64\r\n"
        . "Content-Disposition: attachment; filename=\"file.csv\"\r\n"
        . "\r\n"
        . "$attachment\r\n"
        . "--$multipartSep--";

   // Send the email, return the result
   return @mail($to, $subject, $body, implode("\r\n", $headers)); 

}

//$array = array(array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7), array(1,2,3,4,5,6,7));

send_csv_mail($csv , $message , $EmailTo , $EmailSubject , $EmailFrom);
?>