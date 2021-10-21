<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();

try{
    // ! method: perubahan or pembelian
    // ! perubahan = perubahan by admin
    // ! pembelian = pembelian by pelanggan

    // * ASUMSI:
    // * - kalo pembelian itu gamasuk ke riwayat perubahan tapi cuma ke riwayat pembelian, vice versa
    // * - pas perubahan by admin inputnya new amount
    // * - pas pembelian inputnya amount yg dibeli

    echo $_POST["id"];

    if ($_POST["id"] && $_POST["amount"] && $_POST["method"]) {
        $dorayaki = $db->query("SELECT * FROM dorayaki where id = " . $_POST["id"])->fetch();
        $stmt_dorayaki = $db->prepare("UPDATE dorayaki SET amount = ? WHERE id = ?");

        if($_POST["method"] == "pembelian"){

            $new_amount = (int) $dorayaki["amount"] - (int) $_POST["amount"];
            $total_price = ((int) $dorayaki["price"]) * ((int) $_POST["amount"]);
            $stmt_riwayat = $db->prepare("INSERT INTO riwayat_pembelian (id_dorayaki, id_user, amount, total_price, buy_time) VALUES (?,?,?,?,datetime());");
            $stmt_riwayat->execute(array($_POST["id"], 1, $_POST["amount"], $total_price));
            $stmt_dorayaki->execute(array($new_amount, $_POST["id"]));

        } else if ($_POST["method"] == "perubahan"){

            $new_amount = (int) $_POST["amount"];
            $amount_changed = (int) $_POST["amount"] - (int) $dorayaki["amount"];
            $stmt_riwayat = $db->prepare("INSERT INTO riwayat_perubahan (id_dorayaki, id_user, amount_changed, new_amount, change_time) VALUES (?,?,?,?,datetime());");
            $stmt_riwayat->execute(array($_POST["id"], 1, $amount_changed, $new_amount));
            $stmt_dorayaki->execute(array($new_amount, $_POST["id"]));
            header('Location: change-amount-page.php?id='.$_POST["id"].'&success=true');

        } else {
            throw new Exception("method not available", 1);            
        }
        
        // echo $stmt->rowCount();
        // TODO: harusnya diredirect
    } else {
        // TODO: harusnya diredirect
        header('Location: change-amount-page.php?id='.$_POST["id"].'&success=false');
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>