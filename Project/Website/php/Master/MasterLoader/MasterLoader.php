<?php

require 'Classes/HTMLElement.php';
require 'Classes/HTMLElementDependencies.php';

class MasterLoader {
    public function __construct() {
        $this->htmlHTMLElement = new HTMLElement(
            MasterLoader::$htmlElementName,
            MasterLoader::$htmlElementsFolderPath,
            MasterLoader::$htmlElementsFileExtension,
            MasterLoader::$htmlStartFileName,
            MasterLoader::$htmlEndingFileName
        );
        $this->htmlHeadElement = new HTMLElement(
            MasterLoader::$headElementName,
            MasterLoader::$htmlElementsFolderPath,
            MasterLoader::$htmlElementsFileExtension,
            MasterLoader::$headStartFileName,
            MasterLoader::$headEndingFileName
        );

        $this->htmlHTMLElement->begginingDependencies = new HTMLElementDependencies(
            [],
            [$this->htmlHeadElement]
        );
        $this->htmlHTMLElement->endingDependencies = new HTMLElementDependencies(
            [],
            [$this->htmlHeadElement]
        );
        $this->htmlHeadElement->begginingDependencies = new HTMLElementDependencies(
            [$this->htmlHTMLElement],
            []
        );
        $this->htmlHeadElement->endingDependencies = new HTMLElementDependencies(
            [$this->htmlHTMLElement],
            []
        );
    }

    public function BeginHTML() {
        $this->htmlHTMLElement->Begin();
    }

    public function EndHTML() {
        $this->htmlHTMLElement->End();
    }

    public function BeginHead() {
        $this->htmlHeadElement->Begin();
    }

    public function EndHead() {
        $this->htmlHeadElement->End();
    }

    private $htmlHTMLElement;
    private $htmlHeadElement;

    private static $htmlElementsFolderPath = __DIR__ . '/HTMLElements/';
    private static $htmlElementsFileExtension = '.html';

    private static $htmlElementName = 'HTML';
    private static $htmlStartFileName = 'html_start';
    private static $htmlEndingFileName = 'html_ending';
    private static $headElementName = 'Head';
    private static $headStartFileName = 'head_start';
    private static $headEndingFileName = 'head_ending';
};

?>