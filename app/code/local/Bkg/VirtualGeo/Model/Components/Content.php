<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Format_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Content extends Bkg_VirtualGeo_Model_Components_Component
{
   
	//alias der Tabelle für die Verbindung zum Produkt
	protected $_productRelationTable = 'virtualgeo/components_content_product';
	
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('virtualgeo/components_content');
	}
}
