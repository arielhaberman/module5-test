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
//This is equivalent to what you previously did with $_POST['username'] and $_POST['password']

// Check to see if the username and password are valid.  (You learned how to do this in Module 3.)

$username_array = array();
$password_array = array();
$valid = FALSE;

//accessing the info from the database
$stmt = $mysqli->prepare("select username, password from users");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

$stmt->execute();
$stmt->bind_result($usernames, $hashed_password);

while($stmt->fetch()){
    $username_array[] = $usernames;
    $password_array[] = $hashed_password;
}
$stmt->close();


//check if the username and password are valid
for ($i = 0; $i < sizeof($username_array); $i++) {
    if ($username == $username_array[$i] and password_verify($password, $password_array[$i]))  {
        $valid = TRUE;
    }
}

if($valid){
	session_start();
	$_SESSION['username'] = $username;
    $_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
    $_SESSION["registered"] = TRUE;

	echo json_encode(array(
		"success" => true
	));
	exit;
}else{
    $_SESSION["registered"] = FALSE;
	echo json_encode(array(
		"success" => false,
    ));
	exit;
}
?>
