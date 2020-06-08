<?php
header('Content-type: application/json');
header('Content-Disposition: attachment; filename=UnemploymentData.json');

//echo file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData');

$jsonDecode = json_decode(file_get_contents('http://predictionappapi2.azurewebsites.net/RetrieveData'), true);
$csvString = '';

$csvFile = 'example.csv';
$fp = fopen($csvFile, 'w');

foreach ($jsonDecode as $row) {
    foreach ($row as $row1){
        foreach ($row1 as $row2){
            foreach ($row2 as $row3){
                fputcsv($fp, $row3);
                print_r($row3);
            }
        }
    }
}

$csvString = file_get_contents('example.csv');



//print_r($jsonDecode);
//foreach ($jsonDecode as $row){
//    foreach($row as $secondRow){
//        foreach($secondRow as $thirdRow) {
//            $csvString = $csvString . ', ' . $thirdRow;
//        }
//    }
//}

//echo $csvString;
?>