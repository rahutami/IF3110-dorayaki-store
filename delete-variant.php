<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if ($_POST["id"]) {
        $db->exec("SET foreign_key_checks = 0;");
        
        $stmt = $db->prepare("DELETE FROM dorayaki WHERE id = ?");
        $stmt->execute(array($_POST["id"]));

        $db->exec("SET foreign_key_checks = 1;");
        echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>