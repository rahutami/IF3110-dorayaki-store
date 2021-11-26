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
if(array_key_exists('return', $array['ns2getAllVariantResponse'])){
    $success = true;
    $newArray = $array['ns2getAllVariantResponse']['return'];
} else {
    $success = false;
}
try {
    if(isset($_POST["name"]) && isset($_POST["amount"]) && isset($_POST["price"]) && isset($_POST["description"]) && isset($_POST["img_path"]))
    if ($_POST["name"] && $_POST["amount"] && $_POST["price"] && $_POST["description"] && $_POST["img_path"]) {
        $stmt = $db->prepare("INSERT INTO dorayaki (name, amount, price, description, img_path) VALUES (?,?,?,?,?)");

        // TODO: to be replaced by $_POST
        $stmt->execute(array($_POST["name"], $_POST["amount"], $_POST["price"], $_POST["description"], $_POST["img_path"]));
        header('Location: new-variant-factory.php?success=true');
    } 
    // else {
    //     header('Location: new-variant-factory.php?success=false');
    // }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
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
        <h1>Add New Variant</h1>
        <?php if($success) { ?>
        <form action="" method="POST">
            <div class="input-set">
                <label for="name">Nama Variant</label>
                <?php echo searchById($id,$newArray)["namaDorayaki"]?>
                <input type="hidden" name="name" id="name" value="<?php echo searchById($id,$newArray)["namaDorayaki"]?>">
            </div>
            <div class="input-set">
                <label for="price">Harga</label>
                <input type="number" name="price" id="price">
            </div>
            <div class="input-set">
                <label for="amount">Jumlah</label>
                <input type="number" name="amount" id="amount">
            </div>
            <div class="input-set">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="w3review" name="description" rows="4" cols="50"></textarea>
            </div>
            <div class="input-set">
                <label for="img_path">Gambar</label>
                <input type="text" name="img_path" id="img_path">
            </div>
            <button class="btn-jumbotron">Submit</button>
        <?php } else {
            echo "<p>You have requested too many times or these was an error</p>";
        } ?>
        </form>
    <div>
        <?php if (!isset($_GET["success"])) { 

        } else if ($_GET["success"] == "true") {?>
        <h3>Varian baru telah berhasil diunggah</h3>
        <?php } else if ($_GET["success"] == "false"){ ?>
        <h3>Data tidak lengkap</h3>
        <?php } ?>

    </div>
    </div>
    <!-- footer -->
    <footer>Footer</footer>
</body>
</html>