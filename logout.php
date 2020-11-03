<?php
    session_start();
    session_destroy();
    header("Location: /~arielhaberman/module5-test/login.php");
    exit;
?>
