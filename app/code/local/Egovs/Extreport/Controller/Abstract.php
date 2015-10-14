<?php

/**
 * Abstrakter Report-Admin Controller
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Extreport_Controller_Abstract extends Mage_Adminhtml_Controller_Action
{
	protected $_base = 'report';
	
	protected $_group = '';
	
	protected function _isAllowed() {
		try {
			if ($this->getRequest()->getParam('action')) {
				$action = $this->getRequest()->getParam('action');
			} else {
				$action = $this->getRequest()->getActionName();
			}
			if ($action == 'grid' || (strlen($action) > 5 && substr($action, 0, 6) == 'export')) {
				return Mage::getSingleton('admin/session')->isAllowed(sprintf("%s/%s", $this->_base,$this->_group));
			}
			
			return Mage::getSingleton('admin/session')->isAllowed(sprintf("%s/%s/%s", $this->_base,$this->_group,$action));
		} catch (Exception $e) {
			return false;
		}
	}
	
	/**
	 * Wichtig für AJAX Request
	 * 
	 * @return string
	 */
	abstract public function gridAction();
}