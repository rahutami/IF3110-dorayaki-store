<?php
require_once('./db/DBConnection.php');
$db = (new DBConnection())->connect();
require_once('check-login-state.php');

if (isset($COOKIE["admin"]) && $COOKIE["admin"] != 1) {
    // TODO: selain admin ga bisa add variant, redirect
}
function searchById($id, $array) {
    foreach ($array as $key => $val) {
        if ($val['id'] === $id) {
            $newKey = $key;
            return $array[$newKey];
        }
    }
    return null;
 }
$id = $_GET["id"];
$reqXML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.dorayakisupplier.com/">
<soapenv:Header/>
<soapenv:Body>
    <ser:getAllVariant>
        <arg0 xmlns="">'.$_SERVER['REMOTE_ADDR'].'</arg0>
    </ser:getAllVariant>
</soapenv:Body>
</soapenv:Envelope>';

$soapUrl = "http://localhost:8080/variant";

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
$newArray = $array['ns2getAllVariantResponse']['return'];

?>

<!DOCTYPE html>
<html lang="en">

<?php require_once('_header.php')?>

<body>
    <!-- navbar -->
    
    <?php require_once('_navbar.php')?>
    <!-- product -->
    <div class="container">
        <h1>Add New Variant</h1>
        <h2>Available dorayaki from factory: </h2>
        <div class="dashboard-container">

        <?php $newArray ?>
        <?php
        for ($i=0;$i<(count($newArray));$i++) { ?>
            <div class='item'>
                <a href="new-variant-factory.php?id=<?php echo $newArray[$i]["id"]?>"><?php echo $newArray[$i]["id"]?></a>
                <p><?php echo $newArray[$i]["namaDorayaki"]?></p>
            </div>
        <?php } ?>

        </div>
    </div>
    <!-- footer -->
    <footer>Footer</footer>
</body>
</html>