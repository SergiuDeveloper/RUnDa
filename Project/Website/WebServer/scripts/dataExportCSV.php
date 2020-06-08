<?php
header('Content-type: application/json');
header('Content-Disposition: attachment; filename=UnemploymentData.json');

echo file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData');

$jsonDecode = json_decode(file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData'), true);
$csvString = '';

foreach ($jsonDecode as $row){
    $csvString = $csvString . ', ' . $row;
}

echo $csvString;
?>