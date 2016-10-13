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
class Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo extends Sid_ExportOrder_Model_Format_Opentrans_Abstract
{
	
	protected $_Tag = "ORDER_INFO";
	
	
	/* @var $order_id Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderId */
public $order_id = null;
/* @var $order_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderDate */
public $order_date = null;
/* @var $delivery_date Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate */
public $delivery_date = null;
/* @var $parties Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties */
public $parties = null;
/* @var $customer_order_reference Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference */
public $customer_order_reference = null;
/* @var $order_parties_reference Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference */
public $order_parties_reference = null;
/* @var $docexchange_parties_reference Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DocexchangePartiesReference */
public $docexchange_parties_reference = null;
/* @var $payment Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment */
public $payment = null;
/* @var $terms_and_conditions Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_TermsAndConditions */
public $terms_and_conditions = null;
/* @var $partial_shipment_allowed Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_PartialShipmentAllowed */
public $partial_shipment_allowed = null;
/* @var $remarks Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Remarks */
public $remarks = null;
/* @var $header_udx Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_HeaderUdx */
public $header_udx = null;
/* @var $currency Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Currency */
public $currency = null;
/* @var $transport Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport */
public $transport = null;
/* @var $international_restrictions Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_InternationalRestrictions */
public $international_restrictions = null;



	public function __construct($parent, $order)
    {
		parent::__construct($parent, $order);
		$node = $this->getXmlNode();
		$this->order_id = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderId($node,$this->_xml);
$this->order_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderDate($node,$this->_xml);
$this->delivery_date = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DeliveryDate($node,$this->_xml);
$this->parties = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Parties($node,$this->_xml);
$this->customer_order_reference = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_CustomerOrderReference($node,$this->_xml);
$this->order_parties_reference = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_OrderPartiesReference($node,$this->_xml);
$this->docexchange_parties_reference = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_DocexchangePartiesReference($node,$this->_xml);
$this->payment = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Payment($node,$this->_xml);
$this->terms_and_conditions = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_TermsAndConditions($node,$this->_xml);
$this->partial_shipment_allowed = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_PartialShipmentAllowed($node,$this->_xml);
$this->remarks = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Remarks($node,$this->_xml);
$this->header_udx = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_HeaderUdx($node,$this->_xml);
$this->currency = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Currency($node,$this->_xml);
$this->transport = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_Transport($node,$this->_xml);
$this->international_restrictions = new Sid_ExportOrder_Model_Format_Opentrans_OrderHeader_OrderInfo_InternationalRestrictions($node,$this->_xml);
	}
	
	
	
    
}
