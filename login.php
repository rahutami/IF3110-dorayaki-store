<?php
	// starting the session
	session_start();

    if (isset($_SESSION['username'])) {
        // TODO ganti redirectnya
        header("Location: home.php");
    }

    require_once('db/DBConnection.php');
    $db = (new DBConnection())->connect();

    try{
        if (isset($POST['login'])) {
            $username = $_POST['username'];
            $password_input  = $_POST['password'];
            $stmt = $db->prepare("SELECT name, password FROM user WHERE name = $username");
            $stmt->execute();
            $row = $stmt->fetch();
            if (count($row) > 0) {  
                $password = $row['password'];
                if (password_verify($password_input, $password)) {
                    session_start();
                    $_SESSION['username'] = $username;
                    $_SESSION['password'] = $password;
                    // TODO ganti redirectnya
                    // if login successful
                    header("Location: login-successful.php");
                    // die();
                }
            }
            else {
                header("Location: login-failed.php");
            }
        }
        // else {
        //     echo 'Login gagal silakan coba lagi';
        // }

    } catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
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