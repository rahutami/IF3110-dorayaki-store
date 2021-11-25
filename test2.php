<!-- $xml = file_get_contents($response);
// SimpleXML seems to have problems with the colon ":" in the <xxx:yyy> response tags, so take them out
$xml = preg_replace(/(<\/?)(\w+):([^>]*>)/, $1$2$3, $xml);
$xml = simplexml_load_string($xml);
$json = json_encode($xml);
$responseArray = json_decode($json,true); -->

<?php

$result = $client->__soapCALL
?>