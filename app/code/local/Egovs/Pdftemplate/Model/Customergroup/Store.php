<?php

/**
 * 
 *  Persistenz objekt für Template Definitionen 
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Customergroup_Store extends Mage_Core_Model_Abstract
{
	public function _construct()
	{
		parent::_construct();
		$this->_init('pdftemplate/customergroup_store');
	}

	public function loadByStore($customergroup,$store)
	{
		//$this->_beforeLoad($id, $field);
		$this->_getResource()->loadByStore($this, $customergroup,$store);
		$this->_afterLoad();
		$this->setOrigData();
		$this->_hasDataChanges = false;
		return $this;
		
		
	}
	
}