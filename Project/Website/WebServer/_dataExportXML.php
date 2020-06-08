<?php
//header('Content-type: application/json');
//header('Content-Disposition: attachment; filename=UnemploymentData.json');

$jsonData = json_decode(file_get_contents('http://unemploymentpredictionapi.azurewebsites.net/RetrieveData'), true);

function parseJSONToXMLRec($array){
    $stringValue = '';

    if(is_array($array)){
        foreach($array as $key => $value){
            if(strchr($key, ' '))
                str_replace(' ', '_', $key);

            if(is_array($value)){
                $stringValue = $stringValue .  '<' . $key . '>' . parseJSONToXMLRec($value) . '</' . $key . '>';
            }
            else {
                $stringValue = $stringValue .  '<' . $key . '>' . $value . '</' . $key . '>';
            }

        }
    }

    return $stringValue;
}
//
//$test_array = array (
//    'bla' => 'blub',
//    'foo' => 'bar',
//    'another_array' => array (
//        'stack' => 'overflow',
//    ),
//);

//$jsonData = $test_array;

echo parseJSONToXMLRec($jsonData);

//
//
//$xml = new SimpleXMLElement('<root/>');
//array_walk_recursive($test_array, array ($xml, 'addChild'));
//print $xml->asXML();
?>


