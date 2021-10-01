<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if(true){
        // TODO: uncomment once frontend is ok
    // if ($_POST["id"] || $_POST["name"] ) {
        $stmt = $db->prepare("DELETE FROM dorayaki WHERE id = ?");

        // TODO: to be replaced by $_POST
        $stmt->execute(array(3));

        echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>