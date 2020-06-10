<?php
    require_once('libraries/tcpdf/tcpdf.php');

    $countyColors = explode(',', $_GET['CountyColors']);
    for ($i = 0; $i < count($countyColors); ++$i) {
        $countyColors[$i] = str_replace('rgba(', '', $countyColors[$i]);
        $countyColors[$i] = str_replace(')', '', $countyColors[$i]);
        $countyColors[$i] = explode(';', $countyColors[$i]);
        $r = $countyColors[$i][0];
        $g = $countyColors[$i][1];
        $b = $countyColors[$i][2];
        $countyColors[$i] = "rgb({$r},{$g},{$b})";
    }

    $svgContent = file_get_contents('resources/svg/RO_Map.svg');

    $svgContent = str_replace('<path', '<path fill="%s" ', $svgContent);
    $svgContent = vsprintf($svgContent, $countyColors);

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->AddPage();
    $pdf->ImageSVG("@{$svgContent}", -60, 10, '', '', '', '', '', 1, false);
    $pdf->Write(0, $txt='', '', 0, 'L', true, 0, false, false, 0);
    
    $pdf->Output('RO_Map.pdf', 'D');
?>