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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "SOURCING_INFO";
	
	
	/* @var $quotation_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_QuotationId */
public $quotation_id = null;
/* @var $agreement Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement */
public $agreement = null;
/* @var $catalog_reference Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference */
public $catalog_reference = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->quotation_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_QuotationId($node,$this->_xml);
$this->agreement = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_Agreement($node,$this->_xml);
$this->catalog_reference = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_SourcingInfo_CatalogReference($node,$this->_xml);
	}
	
	
	
    
}
