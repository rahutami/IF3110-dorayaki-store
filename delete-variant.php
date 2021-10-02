<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if ($_POST["id"]) {
        $stmt = $db->prepare("DELETE FROM dorayaki WHERE id = ?");

        $stmt->execute(array($_POST["id"]));

        echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>