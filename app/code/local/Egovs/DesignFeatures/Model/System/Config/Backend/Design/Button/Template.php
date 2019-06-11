<?php
/**
 * Configuration für Button-Caption on Language-Overlay
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author     Magento Core Team <core@magentocommerce.com>
 */

 class Egovs_DesignFeatures_Model_System_Config_Backend_Design_Button_Template extends Mage_Core_Model_Config_Data
 {
     public function toOptionArray()
     {
         return array(
             array('value' => 1, 'label' => Mage::helper('egovsbase')->__('%contry name%')),
             array('value' => 2, 'label' => Mage::helper('egovsbase')->__('%contry name% %country language%')),
             array('value' => 3, 'label' => Mage::helper('egovsbase')->__('%country language%')),
             array('value' => 4, 'label' => Mage::helper('egovsbase')->__('%country code%')),
             array('value' => 5, 'label' => Mage::helper('egovsbase')->__('%store title%')),
             array('value' => 6, 'label' => Mage::helper('egovsbase')->__('%store title% %country language%')),
         );
     }
 }
