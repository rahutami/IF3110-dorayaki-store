<?php
require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();
// jika sudah login
if (isset($_COOKIE["name"]) AND isset($_COOKIE["id"]) AND isset($_COOKIE["admin"]) AND isset($_COOKIE["token"])) {
    header("Location: dashboard.php");
}
// jika belum login atau sudah logout
try{
    if ($_POST["username"] && $_POST["password"] && $_POST["email"]) {
        $hashed_password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        // cek apakah username sudah ada di basis data atau belum
        $username_input = $_POST["username"];
        $stmtUsername = $db->prepare('SELECT name FROM user where name = (?)');
        $stmtUsername->execute(array($username_input));
        $row = $stmtUsername->fetch();
        if (empty($row) != 1) {
            $isValid = false;
            $errorMessage = "Username already taken";
        }
        else {
            $isValid = true;
            $errorMessage = "";
        }
        if ($isValid) {
            // insert new user data
            $stmt = $db->prepare("INSERT INTO user (name, password, email) VALUES (?,?,?)");
            $stmt->execute(array($_POST["username"], $hashed_password, $_POST["email"]));
            // automatically login after register
            $stmtLogin = $db->prepare('SELECT id, name, password, admin FROM user WHERE name = (?)');
            $stmtLogin->execute(array($_POST["username"]));
            $rowLogin = $stmtLogin->fetch();
            if (empty($rowLogin) != 1) {
                $id = $rowLogin["id"];
                $name = $rowLogin["name"];
                $password = $rowLogin["password"];
                $admin = $rowLogin["admin"];
                $random_number = rand(1,99);
                $token = password_hash($random_number,PASSWORD_DEFAULT);
                $stmtToken= $db->prepare("INSERT INTO riwayat_login (id_user, name, token) VALUES (?,?,?);");
                $stmtToken->execute(array($id, $name, $token));
                // set cookie, expiration time: 1 hour
                setcookie('id', $id, time() + 3600);
                setcookie('name', $name, time() + 3600);
                setcookie('admin', $admin, time() + 3600);
                setcookie('token', $token, time() + 3600);
                header("Location: dashboard.php");
            }
        }
        else {
            // username already taken
            echo "<script>alert('Username already taken')</script>";
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
            <h1>Register</h1>
            <div class="form-group" id="usernameValidity"></div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" pattern="^([a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)" required/>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username-not-valid" name="username" placeholder="Username" pattern="([A-Za-z0-9_])+" onkeyup="checkUsernameValidity(this.value)" required />
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required />
            </div>
            <div class="form-group">
                <input type="submit" class="registerbtn" name="register" value="Register" />
            </div>

        </div>

    </form>
</body>
<script>
function checkUsernameValidity(str) {
  if (str.length == 0) {
    document.getElementById("usernameValidity").innerHTML = "";
    document.getElementById("username-not-valid").style.border = "none";
    return;
  } 
  else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      if (this.responseText == "valid") {
          document.getElementById("username-not-valid").style.border = "3px solid green";
          document.getElementById("usernameValidity").innerHTML = "";
      }
      else {
        document.getElementById("username-not-valid").style.border = "none";
        document.getElementById("usernameValidity").innerHTML = "Username " + this.responseText;
      }
    }
  xmlhttp.open("GET", "check-username-validity.php?username=" + str);
  xmlhttp.send();
  }
}
</script>
</html>