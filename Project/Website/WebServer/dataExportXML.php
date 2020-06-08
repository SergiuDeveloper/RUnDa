<?php
header('Content-type: application/json');
header('Content-Disposition: attachment; filename=UnemploymentData.json');

$jsonText = json_decode(file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData'), true);

$xmlText = new SimpleXMLElement('<root/>');
array_walk_recursive($jsonText, array($xmlText, 'addChild'));
print_r ($xmlText->asXML());
?>


