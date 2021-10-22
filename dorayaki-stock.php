<?php
require_once('db/DBConnection.php');
$db = (new DBConnection())->connect();
try {
    $id = $_GET["id"];
    $stmt = $db->prepare('SELECT amount FROM dorayaki where id = (?)');
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    if (empty($row) == 1) {
        $amount = 0;
    }
    else {
        $amount = $row["amount"];
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
echo $amount;
?>