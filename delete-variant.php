<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

if ($COOKIE["admin"] != 1) {
    // TODO: selain admin ga bisa delete variant, redirect
}
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