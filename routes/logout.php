<?php 
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
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
    <label for="username">Username</label>
    <input class="form-control" type="text" name="username" placeholder="Username" />
    <label for="password">Password</label>
    <input class="form-control" type="password" name="password" placeholder="Password" />

<input class="form-control" type="submit" class="btn-register" name="register" value="Submit"/>
</div>

</form>
</body>
</html>
