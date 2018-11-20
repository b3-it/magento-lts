<?php
class Egovs_Base_Model_System_Config_Design_Header_Ajaxsearch_Modes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('egovsbase')->__('Always display')),
            array('value'=>1, 'label'=>Mage::helper('egovsbase')->__('Always hide')),
            array('value'=>2, 'label'=>Mage::helper('egovsbase')->__('Only visible for registered customers')),
        );
    }

}
