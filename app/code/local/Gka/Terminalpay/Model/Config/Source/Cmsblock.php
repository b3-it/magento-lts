<?php

/**
 * Terminalpay über Saferpay Model
 *
 * @category   	Gka
 * @package    	Gka_Terminalpay
 * @name       	Gka_Terminalpay_Model_Terminalpay
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Egovs_Paymentbase_Model_Saferpay
 */

class Gka_Terminalpay_Model_Config_Source_Cmsblock
{
	public function toOptionArray() {
    	$res = array();
        $collection = Mage::getModel('cms/block')->getCollection();
        $collection->distinct('identifier');
        $collection->load();
        $res[] = array('value' => '', 'label' => Mage::helper('terminalpay')->__('No custom info'));
        $_config = Mage::getConfig()->getModuleConfig('Gka_Terminalpay');
        if (version_compare($_config->version, '2.1', '>=')) {
	        foreach($collection->getItems() as $item) {
	        	$res[] = array('value'=>Mage::helper('core')->escapeHtml($item->getData('identifier')),'label'=>sprintf("%s [%s]", Mage::helper('core')->escapeHtml($item->getData('title')), Mage::helper('core')->escapeHtml($item->getData('identifier'))));
	        }
        }
    	
    	return $res;
    }
}