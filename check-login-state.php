<?php
    if (isset($_COOKIE["name"]) AND isset($_COOKIE["id"]) AND isset($_COOKIE["admin"]) AND isset($_COOKIE["token"])) {
        $id = $_COOKIE["id"];
        $username = $_COOKIE["name"];
        $token = $_COOKIE["token"];
        $stmtLogin = $db->prepare('SELECT id_user, name, token FROM riwayat_login WHERE id_user = (?) AND name = (?) AND token = (?)');
        $stmtLogin->execute(array($id, $username, $token));
        $row = $stmtLogin->fetch();
        if ($row["id_user"] == $_COOKIE["id"] && $row["name"] == $_COOKIE["name"] && $row["token"] == $_COOKIE["token"]) {
            $loginState = true;
        }
    }
    // kalo belum login, gabisa akses page tsb dan diredirect ke login
    else {
        header("Location: login.php");
    }
?>
