<?php
require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();
try {
    $username = $_REQUEST["username"];
    $stmt = $db->prepare('SELECT name FROM user where name = (?)');
    $stmt->execute(array($username));
    $row = $stmt->fetch();
    if (empty($row) != 1) {
        $isValid = false;
    }
    else {
        $isValid = true;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo $isValid === true ? "valid" : "not valid";
?>