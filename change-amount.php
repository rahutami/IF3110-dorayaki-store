<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if ($_POST["id"] && $_POST["amount"] && $_POST["method"]) {

        if($_POST["method"] == "decrement"){
            // *command for decrement
            $stmt = $db->prepare("UPDATE dorayaki SET amount = amount - ? where id = ?");
            $stmt->execute(array($_POST["amount"], $_POST["id"])); // amount = amount - 
        } else if ($_POST["method"] == "change"){
            // *command for changing amount
            $stmt = $db->prepare("UPDATE dorayaki SET amount = ? where id = ?");
            $stmt->execute(array($_POST["amount"], $_POST["id"])); // --> amount = 2;
        }
        // echo $stmt->rowCount();
    } else {
        echo "please include id, amount, and method";
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>