<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

if ($COOKIE["admin"] != 1) {
    // TODO: selain admin ga bisa add variant, redirect
}

try{
        // TODO: uncomment once frontend is ok
    if ($_POST["name"] && $_POST["amount"] && $_POST["price"] && $_POST["description"] && $_POST["img_path"]) {
        $stmt = $db->prepare("INSERT INTO dorayaki (name, amount, price, description, img_path) VALUES (?,?,?,?,?)");

        // TODO: to be replaced by $_POST
        $stmt->execute(array($_POST["name"], $_POST["amount"], $_POST["price"], $_POST["description"], $_POST["img_path"]));
        header('Location: new-variant.php?success=true');
    } else {
        header('Location: new-variant.php?success=false');
    }


} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>