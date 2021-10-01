<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if(true){
        // TODO: uncomment once frontend is ok
    // if ($_POST["id"] || $_POST["name"] ) {
        $stmt = $db->prepare("UPDATE dorayaki SET amount = ? ? where id = ?");

        // TODO: to be replaced by $_POST
        // *command for decrement
        $stmt->execute(array('amount -', 2, 4)); // amount = amount - 

        // *command for changing amount
        // $stmt->execute(array('', 2, 4)); --> amount = 2

        echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>