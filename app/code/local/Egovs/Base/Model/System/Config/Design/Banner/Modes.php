<?php
class Egovs_Base_Model_System_Config_Design_Banner_Modes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('egovsbase')->__('Not selected')),
            array('value'=>1, 'label'=>Mage::helper('egovsbase')->__('Above the page content')),
            array('value'=>2, 'label'=>Mage::helper('egovsbase')->__('Inside the page content')),
        );
    }

}
