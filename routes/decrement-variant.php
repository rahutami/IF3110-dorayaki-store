<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if(true){
        // TODO: uncomment once frontend is ok
    // if ($_POST["id"] || $_POST["name"] ) {
        $stmt = $db->prepare("UPDATE dorayaki SET amount = amount - ? where id = ?");

        // TODO: to be replaced by $_POST
        $stmt->execute(array(2, 4));

        echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>