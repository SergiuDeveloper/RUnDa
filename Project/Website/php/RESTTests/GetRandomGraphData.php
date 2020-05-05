<?php

    if(!defined('ROOT'))
        define('ROOT', dirname(__FILE__) . '/..');

    require_once (ROOT . '/Utility/GeneralUtilities.php');

    CommonEndPointLogic::ValidateHTTPGETRequest();

    $chartSectionsCount = $_GET['sectionsCount'];
    $chartSectionLabels = json_decode($_GET['sectionLabels'],true);
    $dataCeiling        = $_GET['dataCeiling'];
    $dataFloor          = $_GET['dataFloor'];

    $valuesArray = array();
    $coloursArray = array();
    $borderColoursArray = array();

    if(count($chartSectionLabels) != $chartSectionsCount)
        ResponseHandler::getInstance()
            ->setResponseHeader(CommonEndPointLogic::GetFailureResponseStatus("INVALID_DATA_SET"))
            ->send();

    foreach ($chartSectionLabels as $chartSectionLabel){
        $data = rand($dataFloor, $dataCeiling);

        $colourString = 'rgba(' . rand(0, 255) . ', ' . rand(0,255) . ', ' . rand(0,255) . ', ';
        $colourStringBorder = $colourString . '1)';
        $colourString = $colourString . '0.2)';

        array_push($valuesArray, $data);
        array_push($coloursArray, $colourString);
        array_push($borderColoursArray, $colourStringBorder);
    }

    try {
        ResponseHandler::getInstance()
            ->setResponseHeader(CommonEndPointLogic::GetSuccessResponseStatus())
            ->addResponseData("data", $valuesArray)
            ->addResponseData("backgroundColor", $coloursArray)
            ->addResponseData("borderColor", $borderColoursArray)
            ->send();
    } catch (Exception $e) {
        ResponseHandler::getInstance()
            ->setResponseHeader(CommonEndPointLogic::GetFailureResponseStatus("INTERNAL_SERVER_ERROR"))
            ->send(StatusCodes::INTERNAL_SERVER_ERROR);
    }

?>