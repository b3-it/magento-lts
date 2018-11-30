<?php
class Egovs_Base_Model_System_Config_Source_Shop_Modes
{

    public function toOptionArray()
    {
        return array(
            array('value'=>0, 'label'=>Mage::helper('egovsbase')->__('Not specified')),
            array('value'=>1, 'label'=>Mage::helper('egovsbase')->__('Test')),
            array('value'=>2, 'label'=>Mage::helper('egovsbase')->__('Integration')),
            array('value'=>3, 'label'=>Mage::helper('egovsbase')->__('Production')),
            array('value'=>4, 'label'=>Mage::helper('egovsbase')->__('Migration')),
        );
    }

}