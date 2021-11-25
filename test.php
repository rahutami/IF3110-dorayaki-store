<?php

$reqXML = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.dorayakisupplier.com/">
                <soapenv:Header/>
                <soapenv:Body>
                    <ser:makeDorayakiRequest>
                        <arg0 xmlns="">1</arg0>
                        <arg1 xmlns="">12</arg1>
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

echo $response; 
// print_r($response);
?>