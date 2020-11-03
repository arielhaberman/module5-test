<?php

    session_start();
    require 'database.php';

    $username_array = array();
    $password_array = array();
    $username = $_GET["username"];
    $password = $_GET["password"];

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


    //check if the entered username is valid
    for ($i = 0; $i < sizeof($username_array); $i++) {
        if ($username == $username_array[$i] and password_verify($password, $password_array[$i]))  {
            $_SESSION["username"] = $username;
            $_SESSION["invalid_login"] = FALSE;
            $_SESSION["registered"] = TRUE;
            header("Location: /~joyceroh/module5-group/mainpage.php");
            exit;
        }
    }
    
    $_SESSION["invalid_login"] = TRUE;
    header("Location: /~joyceroh/module5-group/login.php");
    exit;
?>
