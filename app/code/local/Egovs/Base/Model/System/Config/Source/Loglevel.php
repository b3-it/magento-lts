<?php
class Egovs_Base_Model_System_Config_Source_Loglevel
{

    public function toOptionArray()
    {
        return array(
            array('value'=>Zend_Log::ALERT, 'label'=>Mage::helper('egovsbase')->__('Alert')),
            array('value'=>Zend_Log::CRIT, 'label'=>Mage::helper('egovsbase')->__('Critical')),
            array('value'=>Zend_Log::ERR, 'label'=>Mage::helper('egovsbase')->__('Error')),
            array('value'=>Zend_Log::WARN, 'label'=>Mage::helper('egovsbase')->__('Warning')),
            array('value'=>Zend_Log::NOTICE, 'label'=>Mage::helper('egovsbase')->__('Notice')),
            array('value'=>Zend_Log::INFO, 'label'=>Mage::helper('egovsbase')->__('Info')),
            array('value'=>Zend_Log::DEBUG, 'label'=>Mage::helper('egovsbase')->__('Debug')),
        );
    }

}