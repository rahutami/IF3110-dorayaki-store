<?php 
    session_start();
    session_destroy();
    if (isset($_COOKIE["name"]) AND isset($_COOKIE["password"]) AND isset($_COOKIE["admin"])) {
        setcookie("name", '', time() - (3600));
        setcookie("password", '', time() - (3600));
        setcookie("admin", '', time() - (3600));
    }
    header("Location: login.php");
    exit;
?>