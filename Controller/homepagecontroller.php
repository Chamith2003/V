<?php

class homepagecontroller{
    private $ctrlvar;
    public function __construct($homepagemodel){
        $this->ctrlvar=$homepagemodel;
    }

    public function fetchhighlights(){
        $highlights=$this->ctrlvar->getactivehighlights();
        return $highlights;
    }





}
?>