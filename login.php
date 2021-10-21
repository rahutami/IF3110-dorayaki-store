<?php
    require_once('db/DBConnection.php');
    $db = (new DBConnection())->connect();
    try{
        if (isset($_COOKIE["name"]) AND isset($_COOKIE["password"]) AND isset($_COOKIE["admin"])) {
            // TODO: change redirect kalo admin ke mana, kalo user ke mana
            header("Location: index.php");
        }
        if (isset($_POST['login'])) {
            $username = $_POST['username'];
            $password_input  = $_POST['password'];
            $stmt = $db->prepare('SELECT name, password, admin FROM user WHERE name = (?)');
            $stmt->execute(array($username));
            $row = $stmt->fetch();
            if (empty($row) != 1) {
                $name = $row["name"];
                $password = $row["password"];
                $admin = $row["admin"];
                if (password_verify($password_input, $password)) {
                    setcookie('name', $name, time() + 3600);
                    setcookie('password', $password, time() + 3600);
                    setcookie('admin', $admin, time() + 3600);
                    // TODO: change redirect
                    header("Location: login-successful.php");
                }
                else {
                    echo "wrong password";
                }
            }
            else {
                echo "wrong username";
            }
        }
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
    <title>Stand with Dorayaki</title>
    <link href="../styles/login-register.css" rel="stylesheet" />
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