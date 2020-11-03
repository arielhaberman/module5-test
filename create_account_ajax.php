<?php
require 'database.php';

header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

//Because you are posting the data via fetch(), php has to retrieve it elsewhere.
$json_str = file_get_contents('php://input');
//This will store the data into an associative array
$json_obj = json_decode($json_str, true);

//Variables can be accessed as such:
$username = $json_obj['username'];
$password = $json_obj['password'];
$first_name = $json_obj['first_name'];
$last_name = $json_obj['last_name'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

$username_array = array();
$available = TRUE;

//accessing the info from the database
$stmt = $mysqli->prepare("select username from users");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($usernames);

while($stmt->fetch()){
    $username_array[] = $usernames;
}
$stmt->close();

//check if the entered username is valid
for ($i = 0; $i < sizeof($username_array); $i++) {
    if ($username == $username_array[$i])  {
        $available = FALSE;
    }
}

if ($available) {
    //insert username into database
    $stmt2 = $mysqli->prepare("insert into users (username, first_name, last_name, password) values (?, ?, ?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('ssss', $username, $first_name, $last_name, $hashed_password);

    $stmt2->execute();

    $stmt2->close();
}

if($available){
	session_start();
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 

	echo json_encode(array(
		"available" => true
	));
	exit;
}else{
	echo json_encode(array(
		"available" => false,
    ));
	exit;
}
?>
