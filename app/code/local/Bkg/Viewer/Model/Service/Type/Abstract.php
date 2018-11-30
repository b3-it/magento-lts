<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Model_Service_Type_Wms
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Bkg_Viewer_Model_Service_Type_Abstract extends Varien_Object
{
	
	protected $_type = "wfs";
	protected $_version = "2.0.0";
	protected $_xml;
	protected $_serviceData = array();
	
	public function fetchData($url)
	{
		$this->_fetchData($url);
		return $this->_serviceData;
	}
	
	
	
	
	
	
	
	
}
