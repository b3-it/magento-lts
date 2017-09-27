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

class Bkg_Viewer_Model_Service_Type_Wms extends Bkg_Viewer_Model_Service_Type_Abstract
{
	
	protected $_type = "wms";
	
	
	/**
	 * die UrL Bestimmen
	 * @param array B3it_XmlBind_Wms13_Dcptype $dcp
	 */
	protected function _getHref(array $dcp)
	{
		/* @var B3it_XmlBind_Wms13_Dcptype $d */
		foreach($dcp as $d)
		{
			return $d->getHttp()->getGet()->getOnlineresource()->getAttribute('href');
		}
			
		return "";
	}
	
	
}
