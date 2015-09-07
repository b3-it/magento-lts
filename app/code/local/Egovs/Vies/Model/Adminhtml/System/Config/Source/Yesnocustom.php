<?php
/**
 * Used in creating options for Yes|No|Specified config value selection
 *
 */
class Egovs_Vies_Model_Adminhtml_System_Config_Source_Yesnocustom
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label'=>Mage::helper('adminhtml')->__('Yes')),
            array('value' => 0, 'label'=>Mage::helper('adminhtml')->__('No')),
            array('value' => 2, 'label'=>Mage::helper('egovsvies')->__('No matter'))
        );
    }

}
