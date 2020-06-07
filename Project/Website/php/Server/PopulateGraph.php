<?php

    if(!defined('ROOT')){
        define('ROOT', dirname(__FILE__) . '/..');
    }

    require_once ( ROOT . '/Utility/CommonEndPointLogic.php' );

    $sectionsCount = 7;
    $sectionLabels = ["apples", "pears", "pineapples", "oranges", "bananas", "melons", "grapefruit"];
    $dataFloor = 20;
    $dataCeiling = 100;
    $URL = 'localhost/Website/php/RESTTests/GetRandomGraphData.php';
    $params = [
        'count' => $sectionsCount,
        'labels' => json_encode($sectionLabels),
        'floor'     => $dataFloor,
        'ceiling'   => $dataCeiling
    ];

    $encodedURL = CommonEndPointLogic::encodeGETURLParams($URL, $params);


    $curlHTTPGET = curl_init();

//    $encodedURL = $URL . '?sectionsCount=' . $sectionsCount . '&sectionLabels=' . json_encode($sectionLabels) . '&dataFloor=' . $dataFloor . '&dataCeiling=' . $dataCeiling;

//../php/RESTTests/GetRandomGraphData.php?sectionsCount=7&sectionLabels=["apples","pears","pineapples","oranges","bananas","melons","grapefruits"]&dataFloor=20&dataCeiling=100;
//    $curlSession = curl_init();
//    $curlSession = curl_init(self::$sendGridURL);

//    curl_setopt($curlSession, CURLOPT_POST, true);
//    curl_setopt($curlSession, CURLOPT_POSTFIELDS, $requestParameters);
//    curl_setopt($curlSession, CURLOPT_HEADER, false);
//    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
//    curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, false);
//
//    $azureEmailAPIResponse = curl_exec($curlSession);

    curl_setopt_array(
        $curlHTTPGET, [
            CURLOPT_URL => $encodedURL,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        ]
    );

    $response = curl_exec($curlHTTPGET);

    $responseJSON = json_decode ($response, true);

//    print_r($responseJSON);

    if($responseJSON['responseStatus']['status'] === 'SUCCESS')
        echo json_encode($responseJSON['returnedObject']);

?>