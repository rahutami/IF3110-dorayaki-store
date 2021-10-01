<?php
// require 'functions.php';
if (isset($_POST["register"])) {
    $file_name = 'users' . '.json';
    if (file_exists($file_name)) {
        $data = $_POST;
        $username = $data["username"];
        $password = $data["password"];
        // tambahkan user baru ke file json
        $current_data = file_get_contents($file_name);
        $array_data = json_decode($current_data, true);
        $array_data[$username] = $password;
        $new_data = json_encode($array_data);
        // echo "New data: " . $new_data;
        if (file_put_contents($file_name, $new_data)) {
            echo 'Success';
            header("Location: login.php");
        } else {
            echo 'There is some error';
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
            <h1>Register</h1>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required />
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