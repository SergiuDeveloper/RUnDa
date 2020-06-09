<?php
    $dataType = (isset($_GET['DataType']) ? $_GET['DataType'] : 'JSON');

    $jsonContent = file_get_contents('http://unemploymentpredictionapi.azurewebsites.net/RetrieveData');

//    $jsonContent = file_get_contents('C:\\users\\dadam\\Downloads\\UnemploymentData (2).json');


//    print_r($jsonContent);
//    echo print_r(json_decode($jsonContent, true), PHP_EOL;
//    die();

    switch ($dataType) {
        case 'JSON': {
            header('Content-type: application/json');
            header('Content-Disposition: attachment; filename=UnemploymentData.json');
            echo getDataJSON($jsonContent);
            break;
        }
        case 'XML': {
            header('Content-type: application/xml');
            header('Content-Disposition: attachment; filename=UnemploymentData.xml');
            echo getDataXML($jsonContent);
            break;
        }
        case 'CSV': {
            header('Content-type: application/csv');
            header('Content-Disposition: attachment; filename=UnemploymentData.csv');
            echo getDataCSV($jsonContent);
            break;
        }
    }

    function getDataJSON($jsonContent) {
        return $jsonContent;
    }

    function getDataXML($jsonContent) {
        $dataset = json_decode($jsonContent, true);

        $xmlData = new SimpleXMLElement("<Data></Data>");

        foreach ($dataset['Data'] as $category => $subcategories) {
            $xmlData->addChild('Category');

            $currentCategory = $xmlData->children()[$xmlData->count() - 1];
            $currentCategory->addAttribute('Name', $category);

            foreach ($subcategories as $subcategory => $locations) {
                $currentCategory->addChild('Subcategory');

                $currentSubcategory = $currentCategory->children()[$currentCategory->count() - 1];
                $currentSubcategory->addAttribute('Name', $subcategory);

                foreach ($locations as $location => $regressionTypes) {
                    $currentSubcategory->addChild('Location');

                    $currentLocation = $currentSubcategory->children()[$currentSubcategory->count() - 1];
                    $currentLocation->addAttribute('Name', $location);

                    foreach ($regressionTypes as $regressionType => $data) {
                        $currentLocation->addChild('RegressionType');

                        $currentRegressionType = $currentLocation->children()[$currentLocation->count() - 1];
                        $currentRegressionType->addAttribute('Name', $regressionType);

                        $currentRegressionType->addChild('DataPoints');
                        $currentDataPoints = $currentRegressionType->children()[$currentRegressionType->count() - 1];
                        $dataPoints = $data['DataPoints'];
                        foreach ($dataPoints as $dataPoint) {
                            $currentDataPoints->addChild('DataPoint');

                            $currentDataPoint = $currentDataPoints->children()[$currentDataPoints->count() - 1];
                            $currentDataPoint->addChild('X', $dataPoint['X']);
                            $currentDataPoint->addChild('Y', $dataPoint['Y']);
                        }

                        $currentRegressionType->addChild('Coefficients');
                        $currentCoefficients = $currentRegressionType->children()[$currentRegressionType->count() - 1];
                        $coefficients = $data['Coefficients'];

                        $currentCoefficients->addChild('DataPoint');

                        switch ($regressionType) {
                            case 'Linear': {
                                $currentCoefficients->addChild('w', $coefficients['w']);
                                $currentCoefficients->addChild('b', $coefficients['b']);
                                break;
                            }
                            case 'Polynomial': {
                                $currentCoefficients->addChild('w');

                                $currentWeight = $currentCoefficients->children()[$currentCoefficients->count() - 1];
                                for ($i = 0; $i < count($coefficients['w']); ++$i) {
                                    $polynomialDegree = $i + 1;
                                    $currentWeight->addChild("w{$polynomialDegree}", $coefficients['w'][$i]);
                                }

                                $currentCoefficients->addChild('b', $coefficients['b']);
                                break;
                            }
                            case 'Logistic Polynomial': {
                                $currentCoefficients->addChild('w', $coefficients['w']);
                                $currentCoefficients->addChild('p', $coefficients['p']);
                                $currentCoefficients->addChild('b', $coefficients['b']);
                                break;
                            }
                        }

                        $currentRegressionType->addChild('DataSubtrahend');
                        $currentDataSubtrahend = $currentRegressionType->children()[$currentRegressionType->count() - 1];
                        $currentDataSubtrahend->addChild('X', $data['DataSubtrahend']['X']);
                        $currentDataSubtrahend->addChild('Y', $data['DataSubtrahend']['Y']);

                        $currentRegressionType->addChild('MSE', $data['MSE']);
                    }
                }
            }
        }

        $xmlDOMDocument = new DOMDocument();
        $xmlDOMDocument->preserveWhiteSpace = false;
        $xmlDOMDocument->formatOutput = true;
        $xmlDOMDocument->loadXML($xmlData->asXML());

        return $xmlDOMDocument->saveXML();
    }

    function parseRec($array, $depth, $str, &$csvValue){
        $dataStr = '[';
        foreach($array as $key => $value){
            if(is_array($value)){
                if($key === 'DataPoints'){
                    foreach($value as $dataSetXY){
                        $dataStr = $dataStr . '(' . $dataSetXY['X'] . ';' . $dataSetXY['Y'] . ');';
                    }
                    $dataStr = substr($dataStr, 0, strlen($dataStr) - 1) . '], ';

                }else if($key === 'Coefficients'){
                    if(is_array($value['w'])){
                        $w = '[';
                        foreach($value['w'] as $val)
                            $w = $w . $val . ';';

                        $w = substr($w, 0, strlen($w) - 1) . ']';
                    } else {
                        $w = $value['w'];
                    }

                    if(is_array($value['b'])){
                        $b = '[';
                        foreach($value['b'] as $val)
                            $b = $b . $val . '; ';

                        $b = substr($b, 0, strlen($b) - 1) . ']';
                    } else {
                        $b = $value['b'];
                    }

                    $dataStr = $dataStr . '(' . $w . '; ' . $b . '), ';
                } else if($key === 'DataSubtrahend'){
                    $dataStr = $dataStr . '(' . $value['X'] . '; ' . $value['Y'] . '), ';
                }  else
                parseRec($value,$depth + 1 ,$str . ', ' . $key, $csvValue);
            } else {
                if($key === 'MSE'){
                    $dataStr = $dataStr . $value;
                }
//                echo $str . ', ' . $dataStr , PHP_EOL;
                $csvValue = $csvValue . substr($str, 2, strlen($str)) . ', ' . $dataStr . PHP_EOL;
            }
        }
    }

    function getDataCSV($jsonContent) {
        $dataset = json_decode($jsonContent, true);
        $datasetHeaders = 'Category, Subcategory, Location, RegressionType, DataPoints, DataSubtrahend, Coefficients, MSE';
        echo $datasetHeaders, PHP_EOL;
//        foreach($dataset['Data'] as $category => $subcategory){
//            $datasetHeaders = $datasetHeaders . $category;
//
//        }

        $depth = 8;
        $str = '';
        $csvValue = '';
        parseRec($dataset['Data'], 0, $str, $csvValue);

        return $csvValue;
//        echo $datasetHeaders, PHP_EOL;
        //return '';
    }
?>

