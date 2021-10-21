<?php 
    session_start();
    session_destroy();
    if (isset($_COOKIE["name"]) AND isset($_COOKIE["id"]) AND isset($_COOKIE["admin"]) AND isset($_COOKIE["token"])){
        setcookie("id", '', time() - (3600));
        setcookie("name", '', time() - (3600));
        setcookie("password", '', time() - (3600));
        setcookie("admin", '', time() - (3600));
        setcookie("token", '', time() - (3600));
    }
    header("Location: login.php");
    exit;
?>