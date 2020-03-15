<?php

class HTMLElementDependencies {
    public function __construct($openedTags, $closedTags) {
        $this->openedTags = $openedTags;
        $this->closedTags = $closedTags;
    }

    public $openedTags = [];
    public $closedTags = [];
};

?>