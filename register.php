<?php
require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();
try{
    if ($_POST["username"] && $_POST["password"] && $_POST["email"]) {
        $hashed_password = password_hash($_POST["password"],PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO user (name, password, email) VALUES (?,?,?)");
        $stmt->execute(array($_POST["username"], $hashed_password, $_POST["email"]));
        header('Location: login.php');
    } 
    // else {
        // TODO
        // echo 'There is some error';
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
    <title>Stand with Dorayaki</title>
    <link href="../styles/styles.css" rel="stylesheet" />
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <h1>Register</h1>
            <p id="usernameValidity"></p>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="form-group" id="username-not-valid">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" pattern="([A-Za-z0-9_])+" onkeyup="checkUsernameValidity(this.value)" required />
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
    document.getElementById("usernameValidity").innerHTML = "masih kosong";
    return;
  } else {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
      document.getElementById("usernameValidity").innerHTML = "Response text:"+this.responseText;
    }
  xmlhttp.open("GET", "check-username-validity.php?username=" + str);
  xmlhttp.send();
  }
  // TODO gatau kenapa masih gabisa change bordernya
  if (this.responseText === "not valid") {
    //   document.getElementById("username-not-valid").style.border = "1px solid red";
      let element = document.getElementById("username-not-valid");
      element.setAttribute("style", "border: 2px solid #5A5A5A; color: red");
    //   document.getElementById("username-not-valid").innerHTML = "nottt valid!!";
  }
  if (this.responseText === "valid"){
      document.getElementById("username-not-valid").style.border = "1px solid green";
  }
}
</script>
</html>