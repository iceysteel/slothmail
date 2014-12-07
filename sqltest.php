<?php
$servername = "localhost";
$username = "root";
$password = "U2BWGcJdsz";
$email = $EmailTo;

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

mysqli_select_db($conn,"listbadger");

$sql = "INSERT INTO UserEmails (email)
VALUES ('".$email."')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>