<?php
session_start();

if (isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
if (isset($_POST["login"])) {
    $file_name = 'users' . '.json';

    if (file_exists($file_name)) {
        $data = $_POST;
        $username = $data["username"];
        $password = $data["password"];
        // cek apakah ada user sesuai di users.json
        $current_data = file_get_contents($file_name);
        $array_data = json_decode($current_data, true);
        $search_username = array_search($password, $array_data, true);
        if ($search_username == $username) {
            // set session
            $_SESSION["login"] = true;
            $_SESSION["username"] = $username;
            $_SESSION["cart"] = array();
            $_SESSION["totalItems"] = 0;
            header("Location: pages/index.php");
            exit;
        } else {
            echo ("<script>alert('Unvalid login')</script>");
            header("Location: login.php");
            exit;
        }
    } else {
        echo "File not exists<br>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/styles.css" rel="stylesheet" />
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <h1>Login</h1>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <div class="form-group">
                <input type="submit" class="registerbtn" name="login" value="Login" />
                <button class="btn-jumbotron"><a href="register.php">Register</a></button>

            </div>

        </div>

    </form>
</body>

</html>