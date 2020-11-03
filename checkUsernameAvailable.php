<?php
    session_start();
    require 'database.php';

    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    
    $username_array = array();

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
            $_SESSION["username_taken"] = TRUE;
            header("Location: /~arielhaberman/module5-test/newUser.php");
            exit;
        }
    }

    //insert username into database
    $stmt2 = $mysqli->prepare("insert into users (username, first_name, last_name, password) values (?, ?, ?, ?)");
    if(!$stmt2){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt2->bind_param('ssss', $username, $first_name, $last_name, $hashed_password);

    $stmt2->execute();

    $stmt2->close();

    header("Location: /~arielhaberman/module5-test/createAccountSuccess.php");
    exit;

?>
