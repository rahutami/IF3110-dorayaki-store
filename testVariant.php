<?php
// function object2array($object) { return @json_decode(@json_encode($object),1); }

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

echo $response;
var_dump($response);

echo "ARRAY<br>";
$response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
$xml = new SimpleXMLElement($response);
$body = $xml->xpath('//SBody')[0];
$array = json_decode(json_encode((array)$body), TRUE); 
print_r($array['ns2getAllVariantResponse']['return']);
$newArray = $array['ns2getAllVariantResponse']['return'];
echo "<br>NEW ARRAY<br>";
print_r($newArray);


echo ( $newArray[0]['namaDorayaki']); // coklat
print_r((array_search(1,$newArray)));

echo "<br>PRINT COUNT".count($newArray)."<br>";
var_dump($newArray);
?>