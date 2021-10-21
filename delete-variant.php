<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if ($_POST["id"]) {
        $db->exec("PRAGMA foreign_keys = OFF;");
        
        $stmt = $db->prepare("DELETE FROM dorayaki WHERE id = ?");
        $stmt->execute(array($_POST["id"]));

        $db->exec("PRAGMA foreign_keys = ON;");
        header('Location: dashboard.php');
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>