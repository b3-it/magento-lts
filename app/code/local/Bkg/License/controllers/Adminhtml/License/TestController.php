<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name        Bkg_License_Adminhtml_License_Master_EntityController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Adminhtml_License_TestController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bkglicense/bkglicense_master')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('License Master'), Mage::helper('adminhtml')->__('License Master'));
		$this->_title(Mage::helper('adminhtml')->__('License Master'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
		die('wwww');
	}


}
