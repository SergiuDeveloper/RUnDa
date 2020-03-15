<?php

class HTMLElement {
    public function __construct($elementName, $htmlElementsFolderPath, $htmlElementsFileExtension, $startFileName, $endingFileName) {
        $this->elementName = $elementName;
        $this->htmlElementsFolderPath = $htmlElementsFolderPath;
        $this->htmlElementsFileExtension = $htmlElementsFileExtension;
        $this->startFileName = $startFileName;
        $this->endingFileName = $endingFileName;
    }

    public function __destruct() {
        if (!$this->elementEnded)
            throw new Exception('An used element was never ended - ' . $this->elementName);
    }

    public function Begin() {
        if ($this->elementEnded && $this->elementWasUsed)
            throw new Exception('There was an attempt to begin an element that was already ended - ' . $this->elementName);
        
        if ($this->elementBegun)
            throw new Exception('There was an attempt to begin an element that has already begun - ' . $this->elementName);

        foreach ($this->begginingDependencies->openedTags as $openedTag)
            if (!$openedTag->elementBegun)
                throw new Exception('In order to begin the ' . $this->elementName . ' tag, you have to begin the ' . $openedTag->elementName . ' tag first');
        foreach ($this->begginingDependencies->closedTags as $closedTag)
            if (!$closedTag->elementEnded && $closedTag->elementWasUsed)
                throw new Exception('In order to begin the ' . $this->elementName . ' tag, you have to end the ' . $closedTag->elementName . ' tag first');
        
        $this->elementWasUsed = true;
        $this->elementBegun = true;
        $this->LoadFileContents($this->htmlElementsFolderPath . $this->startFileName . $this->htmlElementsFileExtension);
    }

    public function End() {
        if (!$this->elementBegun)
            throw new Exception('There was an attempt to end an element that hasn\'t been started - ' . $this->elementName);
        
        if ($this->elementEnded && $this->elementWasUsed)
            throw new Exception('There was an attempt to end an element that was already ended - ' . $this->elementName);

        foreach ($this->endingDependencies->openedTags as $openedTag)
            if (!$openedTag->elementBegun)
                throw new Exception('In order to end the ' . $this->elementName . ' tag, you have to begin the ' . $openedTag->elementName . ' tag first');
        foreach ($this->endingDependencies->closedTags as $closedTag)
            if (!$closedTag->elementEnded && $closedTag->elementWasUsed)
                throw new Exception('In order to end the ' . $this->elementName . ' tag, you have to end the ' . $closedTag->elementName . ' tag first');

        $this->elementEnded = true;
        $this->LoadFileContents($this->htmlElementsFolderPath . $this->endingFileName . $this->htmlElementsFileExtension);
    }

    private function LoadFileContents($filePath) {
        $fileContents = file_get_contents($filePath);
        echo $fileContents;
    }

    private $elementName;

    private $htmlElementsFolderPath;
    private $htmlElementsFileExtension;

    private $startFileName;
    private $endingFileName;

    private $elementWasUsed = false;
    private $elementBegun = false;
    private $elementEnded = false;

    public $begginingDependencies;
    public $endingDependencies;
};

?>