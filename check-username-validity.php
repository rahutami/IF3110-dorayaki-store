<?php


require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();

try {
    $username = $_REQUEST["username"];
    $stmt = $db->prepare('SELECT name FROM user where name = (?)');
    $stmt->execute(array($username));
    $row = $stmt->fetch();
    $name = $row["name"];
    if ($name == $username) {
        $validity = false;
    } 
    else {
        $validity = true;
    }
}
catch(PDOException $e) {
echo "Error: " . $e->getMessage();
}
echo $validity === true ? "valid" : "not valid";
?>