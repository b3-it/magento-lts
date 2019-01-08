<?php

class Bkg_Shapefile_Model_Form_File extends Varien_Data_Form_Element_File {
    
    public function getHtmlAttributes() {
        return array_merge(parent::getHtmlAttributes(), array('accept'));
    }
}