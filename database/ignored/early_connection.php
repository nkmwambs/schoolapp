<?php

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT app_id FROM app";
$result = $conn->query($sql);

$apps = array();

$apps[] = $dbname;

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $apps[] = 'school_app'.$row["app_id"];
		
    }
}


$conn->close();

