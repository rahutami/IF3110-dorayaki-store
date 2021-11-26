<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

if (isset($_COOKIE["admin"]) && $_COOKIE["admin"] == 1) {
    $isAdmin = true;
}
else {
    header('Location: login.php');
}

$reqXML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.dorayakisupplier.com/">
<soapenv:Header/>
<soapenv:Body>
    <ser:getStatusRequest>
        <arg0 xmlns="">'.$_SERVER['REMOTE_ADDR'].'</arg0>
    </ser:getStatusRequest>
</soapenv:Body>
</soapenv:Envelope>';

$soapUrl = "http://localhost:8080/status";

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
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
$array = json_decode(json_encode((array)$body), TRUE); 

if(array_key_exists('return', $array['ns2getStatusRequestResponse'])){
    $success = true;
    $arrayStatusRequest = $array['ns2getStatusRequestResponse']['return'];
} else {
    $success = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
    
    <!-- product -->
    <div class="container">
        <?php if ($success){ ?>
        <table>
            <thead style="margin-bottom:40px;">
                <tr>
                    <th>Nama Dorayaki</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    foreach ($arrayStatusRequest as $key => $value) {
                    echo "
                    <tr>
                        <td>".$value["nama"]."</td>
                        <td>".$value["amount"]."</td>
                        <td>".$value["status"]."</td>
                    </tr>";
                    }
                ?>
            </tbody>
        </table>
        <?php } else {
            echo "<p>You have requested too many times or there was an error </p>";
            }
        ?>
    </div>
    <!-- footer -->
    <footer>Footer</footer>
</body>
<script>
    // get total price
    document.getElementById("amount").addEventListener("change", getTotalPrice);
    function getTotalPrice() {
        let price = document.getElementById("price").textContent;
        let amount = this.value;
        let totalPrice = price*amount;
        document.getElementById("totalPrice").innerHTML = totalPrice.toString();
    }
    // real time stock
    function getDorayakiStock() {
        let id = document.getElementById("product-id").textContent;
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.onload = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("dorayaki-stock").innerHTML = this.responseText;
                let amountInput = document.getElementById("amount");
                
                <?php if (!$isAdmin) { ?>
                amountInput.setAttribute("max",(this.responseText));
                <?php } ?>
            }
        }
        xmlhttp.open("GET", "dorayaki-stock.php?id=" + id, true);
        xmlhttp.send();
    }
    getDorayakiStock();
    setInterval(getDorayakiStock,1000); // akan get setiap 1 detik
</script>
</html>