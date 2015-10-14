<?php

/**
 * Store-Switcher-Block
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Customer_Group_Switcher extends Mage_Adminhtml_Block_Template
{
    /**
     * @var bool
     */
    protected $_hasDefaultOption = true;

    /**
     * Setzt ein eigenes Template
     * 
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->setTemplate('egovs/extreport/switcher.phtml');
        $this->setUseConfirm(true);
        $this->setUseAjax(true);
    }

    /**
     * Get Customer groups
     * 
     * @return Mage_Customer_Model_Entity_Group_Collection
     */
    public function getGroupCollection()
    {
        $collection = Mage::getResourceModel('customer/group_collection');
        
        return $collection;
    }

    /**
     * Liefert die URL mit Store-Switch-Parametern
     * 
     * @return string URL
     */
    public function getSwitchUrl()
    {
    	$sw = '';
    	$store = Mage::registry('store');
    	$website = Mage::registry('website');
    	$group = Mage::registry('group');
    	
    	if (isset($store)) {
            $sw = "store/$store";
        } elseif (isset($website)) {
            $sw = "website/$website";
        } elseif (isset($group)) {
            $sw = "group/$group";
        }
        if (strlen($sw) > 0) {
        	$sw .= '/';
        }
        if ($url = $this->getData('switch_url')) {
            return $url.$sw;
        }
        
        return $this->getUrl('*/*/*', array('_current' => true, 'store' => null)).$sw;
    }

    /**
     * Set/Get whether the switcher should show default option
     *
     * @param bool $hasDefaultOption Optionale Übergabe einer Default-option
     * 
     * @return bool
     */
    public function hasDefaultOption($hasDefaultOption = null)
    {
        if (null !== $hasDefaultOption) {
            $this->_hasDefaultOption = $hasDefaultOption;
        }
        return $this->_hasDefaultOption;
    }
}
