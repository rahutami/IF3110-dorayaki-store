<?php
    if (isset($_COOKIE["name"]) AND isset($_COOKIE["id"]) AND isset($_COOKIE["admin"]) AND isset($_COOKIE["token"])) {
        $id = $_COOKIE["id"];
        $username = $_COOKIE["name"];
        $token = $_COOKIE["token"];
        // echo $username;
        // echo $token;
        $stmtLogin = $db->prepare('SELECT id_user, name, token FROM riwayat_login WHERE id_user = (?) AND name = (?) AND token = (?)');
        $stmtLogin->execute(array($id, $username, $token));
        $row = $stmtLogin->fetch();
        // print_r($row);
        if ($row["id_user"] == $_COOKIE["id"] && $row["name"] == $_COOKIE["name"] && $row["token"] == $_COOKIE["token"]) {
            $loginState = true;
        }

        // if ($loginState) {
        //     // TODO: change redirect kalo admin ke mana, kalo user ke mana
        //     if ($_COOKIE["admin"] == 0) {
        //         header("Location: index.php");
        //     }
        //     else {
        //         header("Location: index.php");       
        //     }
        // }
    }
    // kalo belum login, gabisa akses page tsb dan diredirect ke login
    else {
        header("Location: login.php");
    }
?>
