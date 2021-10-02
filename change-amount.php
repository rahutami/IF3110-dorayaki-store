<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
        // TODO: uncomment once frontend is ok
    if ($_POST["id"] || $_POST["amount"] || $_POST["method"]) {
        $stmt = $db->prepare("UPDATE dorayaki SET amount = ? ? where id = ?");

        // TODO: replace by $_POST
        // $method = "decrement";
        if($_POST["method"] == "decrement"){
            // *command for decrement
            $stmt->execute(array('amount -', $_POST["amount"], $_POST["id"])); // amount = amount - 
        } else if ($_POST["method"] == "change"){
            // *command for changing amount
            $stmt->execute(array('', $_POST["amount"], $_POST["id"])); // --> amount = 2;
        }


        // echo $stmt->rowCount();
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>