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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ORDER_PARTIES_REFERENCE";
	
	
	/* @var $invoice_recipient_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_InvoiceRecipientIdref */
public $invoice_recipient_idref = null;
/* @var $shipment_parties_reference Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference */
public $shipment_parties_reference = null;
/* @var $buyer_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_BuyerIdref */
public $buyer_idref = null;
/* @var $supplier_idref Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_SupplierIdref */
public $supplier_idref = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->invoice_recipient_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_InvoiceRecipientIdref($node,$this->_xml);
$this->shipment_parties_reference = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_ShipmentPartiesReference($node,$this->_xml);
$this->buyer_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_BuyerIdref($node,$this->_xml);
$this->supplier_idref = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference_SupplierIdref($node,$this->_xml);
	}
	
	
	
    
}
