<?php
/**
 * Sid_ExportOrder_Model_Format_Opentrans
 *
 * Erzeugen eines XML Streams für OpenTrans 2.1
 * @category   	Sid
 * @package    	Sid_ExportOrder_Format
 * @name       	Sid_ExportOrder_Model_Format_Opentrans
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2016 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "CATALOG_REFERENCE";
	
	
	/* @var $catalog_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogId */
public $catalog_id = null;
/* @var $catalog_version Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogVersion */
public $catalog_version = null;
/* @var $catalog_name Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogName */
public $catalog_name = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->catalog_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogId($node,$this->_xml);
$this->catalog_version = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogVersion($node,$this->_xml);
$this->catalog_name = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference_CatalogName($node,$this->_xml);
	}
	
	
	
    
}
