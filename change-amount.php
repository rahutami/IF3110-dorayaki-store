<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');
try{
    // ! method: perubahan or pembelian
    // ! perubahan = perubahan by admin
    // ! pembelian = pembelian by pelanggan

    // * ASUMSI:
    // * - kalo pembelian itu gamasuk ke riwayat perubahan tapi cuma ke riwayat pembelian, vice versa
    // * - pas perubahan by admin inputnya new amount
    // * - pas pembelian inputnya amount yg dibeli

    // echo $_POST["id"];

    if ($_POST["id"] && $_POST["amount"] && $_POST["method"]) {
        $dorayaki = $db->query("SELECT * FROM dorayaki where id = " . $_POST["id"])->fetch();
        $stmt_dorayaki = $db->prepare("UPDATE dorayaki SET amount = ? WHERE id = ?");

        if($_POST["method"] == "pembelian"){
            $new_amount = (int) $dorayaki["amount"] - (int) $_POST["amount"];
            $total_price = ((int) $dorayaki["price"]) * ((int) $_POST["amount"]);
            $stmt_riwayat = $db->prepare("INSERT INTO riwayat_dorayaki (id_dorayaki, id_user, amount_changed, change_time, total_price, method) VALUES (?,?,?,datetime('now','localtime'),?,?);");
            $stmt_riwayat->execute(array($_POST["id"], $_COOKIE["id"],(-1) * $_POST["amount"], $total_price, "pembelian"));
            $stmt_dorayaki->execute(array($new_amount, $_POST["id"]));
            header('Location: detail.php?id='.$_POST["id"].'&success=true');
        } else if ($_POST["method"] == "perubahan"){
            $reqXML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.dorayakisupplier.com/">
                            <soapenv:Header/>
                            <soapenv:Body>
                                <ser:makeDorayakiRequest>
                                    <arg0 xmlns="">'.$_POST["id"].'</arg0>
                                    <arg1 xmlns="">'.$_POST["amount"].'</arg1>
                                    <arg2 xmlns="">'.$_SERVER['REMOTE_ADDR'].'</arg2>
                                </ser:makeDorayakiRequest>
                            </soapenv:Body>
                            </soapenv:Envelope>';

            $soapUrl = "http://localhost:8080/request-dorayaki";

            $headers = array(
            "POST /package/package_1.3/packageservices.asmx HTTP/1.1",
            "Host: privpakservices.schenker.nu",
            "Content-Type: text/xml",
            "Content-Length: ".strlen($reqXML)
            ); 

            $url = $soapUrl;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $reqXML);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch); 
            curl_close($ch);

            $response1 = str_replace("<soap:Body>","",$response);
            $response2 = str_replace("</soap:Body>","",$response1);

            if (strpos($response, 'success') !== false) { 
                header('Location: detail.php?id='.$_POST["id"].'&success=true');
            } else {
                header('Location: detail.php?id='.$_POST["id"].'&success=false');
            }
           

        } else {
            throw new Exception("method not available", 1);            
        }
        
        // echo $stmt->rowCount();
        // TODO: harusnya diredirect
    } else {
        // TODO: harusnya diredirect
        header('Location: detail.php?id='.$_POST["id"].'&success=false');
    }

} catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>