<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    if(true){
        // TODO: uncomment once frontend is ok
    // if ($_POST["name"] && $_POST["amount"] && $_POST["price"] && $_POST["description"] && $_POST["img_path"]) {
        $stmt = $db->prepare("INSERT INTO dorayaki (name, amount, price, description, img_path) VALUES (?,?,?,?,?)");

        $name="another dorayaki";
        $amount=10;
        $price=20000;
        $description="a delciious dorayaki";
        $img_path="https://assets.pikiran-rakyat.com/crop/0x0:0x0/x/photo/2021/05/07/1038070108.jpeg";

        // TODO: to be replaced by $_POST
        $stmt->execute(array($name, $amount, $price, $description, $img_path));
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>