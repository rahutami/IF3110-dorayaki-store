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
    <title>Booksy</title>
    <link href="../styles/styles.css" rel="stylesheet" />
</head>

<body>
    <form action="" method="post">
        <div class="container">
            <h1>Register</h1>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required />
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" pattern="([A-Za-z0-9_])+" required />
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

</html>