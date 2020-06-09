<?php
    $dataType = (isset($_GET['DataType']) ? $_GET['DataType'] : 'JSON');

    $jsonContent = file_get_contents('http://unemploymentpredictionapi.azurewebsites.net/RetrieveData');

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

    function getDataCSV($jsonContent) {
        $dataset = json_decode($jsonContent, true);
        return '';
    }
?>

