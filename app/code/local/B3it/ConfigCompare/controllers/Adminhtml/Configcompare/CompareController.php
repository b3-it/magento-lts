<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Adminhtml_Configcompare_CompareController extends B3it_ConfigCompare_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout();
		return $this;
	}   
 
	public function indexAction() {
		

		$this->_initAction();
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		
		$this->_addContent($this->getLayout()->createBlock('configcompare/adminhtml_compare_form'))
			->_addLeft($this->getLayout()->createBlock('configcompare/adminhtml_compare_tabs'));
		$this->renderLayout();	
		return $this;
		
	}
	
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('configcompare/adminhtml_import_data_grid')->toHtml()
		);
	}


}