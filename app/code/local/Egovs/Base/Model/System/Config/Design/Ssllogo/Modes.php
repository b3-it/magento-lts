<?php
class Egovs_Base_Model_System_Config_Design_Ssllogo_Modes
{
    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('egovsbase')->__('Yes')),
            array('value'=>1, 'label'=>Mage::helper('egovsbase')->__('No')),
            array('value'=>2, 'label'=>Mage::helper('egovsbase')->__('Display only for HTTPS logon')),
        );
    }

}
