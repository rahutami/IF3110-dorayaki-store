<?php
// if (isset($_COOKIE["name"]) AND isset($_COOKIE["password"]) AND isset($_COOKIE["admin"])) {
//     // TODO: change redirect kalo admin ke mana, kalo user ke mana
//     if ($_COOKIE["admin"] == 0) {
//         header("Location: index.php");
//     }
//     else {
//         header("Location: index.php");       
//     }
// }

require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

try{
    if ($_POST["username"] && $_POST["password"] && $_POST["email"]) {
        $hashed_password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO user (name, password, email) VALUES (?,?,?)");
        $stmt->execute(array($_POST["username"], $hashed_password, $_POST["email"]));
        header('Location: login.php');
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
                <input type="email" name="email" placeholder="Email" required />
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