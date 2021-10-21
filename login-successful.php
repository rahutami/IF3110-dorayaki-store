<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booksy</title>
    <link href="../styles/login-register.css" rel="stylesheet" />
</head>
<body>
<h1>Login successful</h1>

<a href="logout.php">Logout</a>
Logged in as
<?php
echo ($_COOKIE["name"]) . "<br>";
echo ($_COOKIE["admin"]) . "<br>";

?>

</body>
</html>
