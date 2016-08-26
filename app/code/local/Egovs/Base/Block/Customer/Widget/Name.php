<?php
/**
 * Widget Block für Namen eines Customers
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Fochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Customer_Widget_Name extends Mage_Customer_Block_Widget_Name
{
	private $_method = 'register';

    public function _construct() {
        parent::_construct();

        // default template location
        $this->setTemplate('customer/widget/name.phtml');
    }

    public function isFieldRequired($key) {

    	$helper = null;
    	try {
    		$helper = Mage::helper('egovsbase/config');
    	} catch (Exception $e) {
    	}

    	if (is_null($helper)) {
    		return false;
    	}

    	return ($helper->isFieldRequired($key, $this->_method));
    }

    public function setMethod($method)
    {
    	$this->_method = $method;
    	return $this;
    }

    public function getFieldRequiredHtml($name) {
    	if ($this->isFieldRequired($name)) {
    		return '<span class="required">*</span>';
    	}
    	return '';
    }

    public function isFieldVisible($key) {
    	$helper = null;
    	try {
    		$helper = $this->helper('egovsbase/config');
    	} catch (Exception $e) {
    	}

    	if (is_null($helper)) {
    		return true;
    	}

    	return ($helper->getConfig($key, $this->_method) != '');

    }

    public function isPrefixRequired() {
    	return parent::isPrefixRequired() && $this->isFieldRequired('prefix');
    }

    /**
     * Retrieve academic_titel drop-down options
     *
     * @return array|bool
     */
    public function getAcademicTitleOptions($store = null)
    {
        $prefixOptions = $this->helper('customer')->getAcademicTitleOptions($store);

        if ($this->getObject() && !empty($prefixOptions)) {
            $oldPrefix = $this->escapeHtml(trim($this->getObject()->getPrefix()));
            $prefixOptions[$oldPrefix] = $oldPrefix;
        }
        return $prefixOptions;
    }

}
