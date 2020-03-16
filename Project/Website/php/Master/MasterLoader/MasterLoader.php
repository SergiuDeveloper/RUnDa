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

    public static function Load() {
        $masterLoader = new MasterLoader();

        $callerFile = get_included_files()[0];
        $callerFileHTMLContent = file_get_contents($callerFile);

        $callerFileHTMLContent = preg_replace('%(require|include) ((\'Master(/|\\\)LoadMaster.php\')|(\"Master(/|\\\)LoadMaster.php\"))(;?)%', '', $callerFileHTMLContent);

        if (strpos($callerFileHTMLContent, '<html>') != FALSE)
            $callerFileHTMLContent = str_replace('<html>', $masterLoader->BeginHTML(), $callerFileHTMLContent);
        if (strpos($callerFileHTMLContent, '<head>') != FALSE)
            $callerFileHTMLContent = str_replace('<head>', $masterLoader->BeginHead(), $callerFileHTMLContent);
        if (strpos($callerFileHTMLContent, '</head>') != FALSE)
            $callerFileHTMLContent = str_replace('</head>', $masterLoader->EndHead(), $callerFileHTMLContent);
        if (strpos($callerFileHTMLContent, '</html>') != FALSE)
            $callerFileHTMLContent = str_replace('</html>', $masterLoader->EndHTML(), $callerFileHTMLContent);

        eval('?>' . $callerFileHTMLContent . '<?php');
        exit();
    }

    private function BeginHTML() {
        return $this->htmlHTMLElement->Begin();
    }

    private function EndHTML() {
        return $this->htmlHTMLElement->End();
    }

    private function BeginHead() {
        return $this->htmlHeadElement->Begin();
    }

    private function EndHead() {
        return $this->htmlHeadElement->End();
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